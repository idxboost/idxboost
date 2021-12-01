<?php

if (!function_exists('iboost_get_mod_time')) {
    function iboost_get_mod_time($filename)
    {
        return (string)filemtime(FLEX_IDX_PATH . $filename);
    }
}

function ibCodRandow($longitud)
{
    $key = '';
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ';
    $max = strlen($pattern) - 1;

    for ($i = 0; $i < $longitud; $i++) {
        $rand = mt_rand(0, $max);
        $key .= $pattern[$rand];
    }
    return $key;
}

if (!function_exists("flex_idx_track_property_view_xhr_fn")) {
    function flex_idx_track_property_view_xhr_fn()
    {
        $response = [];

        $response = [];
        $access_token = flex_idx_get_access_token();
        $lead_token = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $mls_number = isset($_POST["mls_number"]) ? $_POST["mls_number"] : "";
        $mls_opened_list = isset($_POST["mls_opened_list"]) ? $_POST["mls_opened_list"] : [];
        $board_id = isset($_POST["board_id"]) ? (int)$_POST["board_id"] : 1;
        $client_ip = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $params = [
            "access_token" => $access_token,
            "lead_token" => $lead_token,
            "client_ip" => $client_ip,
            "url_referer" => $referer,
            "url_origin" => $origin,
            "user_agent" => $agent,
            "mls_number" => $mls_number,
            "mls_opened_list" => $mls_opened_list,
            "board_id" => $board_id
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_TRACK_PROPERTY_VIEW);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($output, true);

        wp_send_json($response);
        exit;
    }
}

if (!function_exists("idxboost_agent_contact_inquiry_xhr_fn")) {
    function idxboost_agent_contact_inquiry_xhr_fn()
    {
        $response = [];

        $response = [];
        $access_token = flex_idx_get_access_token();
        $lead_token = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $first_name = isset($_POST["name"]) ? $_POST["name"] : "";
        $last_name = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
        $email_address = isset($_POST["email"]) ? $_POST["email"] : "";
        $phone_number = isset($_POST["phone"]) ? $_POST["phone"] : "";
        $comments = isset($_POST["message"]) ? $_POST["message"] : "";
        $time_to_reach = isset($_POST['option_time']) ? sanitize_text_field($_POST['option_time']) : '';
        $comments = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
        $gender = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $receive_newsletter = isset($_POST['chk']) ? '1' : '0';
        $client_ip = get_client_ip_server();
        $url_referer = isset($_SERVER['HTTP_REFERER']) ? sanitize_text_field($_SERVER['HTTP_REFERER']) : '';
        $url_origin = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field($_SERVER['HTTP_HOST']) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '';
        $access_token = flex_idx_get_access_token();
        $lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $idx_agent_data_email = isset($_POST["idx_agent_data_email"]) ? $_POST["idx_agent_data_email"] : "";
        $idx_agent_data_phone = isset($_POST["idx_agent_data_phone"]) ? $_POST["idx_agent_data_phone"] : "";
        $idx_agent_data_name = isset($_POST["idx_agent_data_name"]) ? $_POST["idx_agent_data_name"] : "";

        $data_agent = [];

        $data_agent['phone'] = $idx_agent_data_phone;
        $data_agent['email'] = $idx_agent_data_email;
        $data_agent['name'] = $idx_agent_data_name;

        $sendParams = array(
            'data_agent' => json_encode($data_agent, true),
            'data' => array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $gender,
                'email_address' => $email_address,
                'phone_number' => $phone_number,
                'time_to_reach' => $time_to_reach,
                'comments' => $comments,
                'receive_newsletter' => $receive_newsletter,
                'client_ip' => $client_ip,
                'url_referer' => $url_referer,
                'url_origin' => $url_origin,
                'user_agent' => $user_agent,
            ),
            'lead_credentials' => $lead_credentials,
            'access_token' => $access_token,
            'server' => $_SERVER
        );

        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_INQUIRY_AGENT_CONTACT_FORM);
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_INQUIRY_CONTACT_FORM);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($output, true);

        wp_send_json($response);
        exit;
    }
}

// for WP-Customizer
if (!function_exists('func_customizer_idxboost')) {
    function func_customizer_idxboost($wp_customize)
    {
        $wp_customize->add_section('idx_plugin_customizer_scheme', array('title' => __('Colors', 'idx_plugin_customizer'), 'priority' => 102,));

        $wp_customize->add_setting('idx_plugin_custom[idx_text_sub_title_search_bar]', array('capability' => 'edit_theme_options', 'default' => '--------------', 'sanitize_callback' => 'sanitize_text_field',));
        $wp_customize->add_control('idx_plugin_custom[idx_text_sub_title_search_bar]', array('type' => 'text', 'section' => 'idx_plugin_customizer_scheme', 'label' => __('Search Bar Title'), 'settings' => 'idx_plugin_custom[idx_text_sub_title_search_bar]',));
        $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_text_sub_title_search_bar]', array('selector' => '.idx_text_sub_title_search_bar', 'render_callback' => array($wp_customize, '_idx_text_sub_title_search_bar'), 'container_inclusive' => true,));


        $wp_customize->add_setting('idx_plugin_custom[idx_text_search_bar]', array('capability' => 'edit_theme_options', 'default' => '--------------', 'sanitize_callback' => 'sanitize_text_field',));
        $wp_customize->add_control('idx_plugin_custom[idx_text_search_bar]', array('type' => 'text', 'section' => 'idx_plugin_customizer_scheme', 'label' => __('Search Bar Text'), 'settings' => 'idx_plugin_custom[idx_text_search_bar]',));
        $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_text_search_bar]', array('selector' => '.idx_text_search_bar', 'render_callback' => array($wp_customize, '_idx_text_search_bar'), 'container_inclusive' => true,));

        $wp_customize->add_setting('idx_plugin_custom[has_button]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control('idx_plugin_custom[has_button]', array('label' => __('Has button ?'), 'section' => 'idx_plugin_customizer_scheme', 'settings' => 'idx_plugin_custom[has_button]', 'type' => 'checkbox'));
        $wp_customize->selective_refresh->add_partial('idx_plugin_custom[has_button]', array('selector' => '.idx_languages_english', 'render_callback' => array($wp_customize, '_idx_tesoro_english'), 'container_inclusive' => true));

        $wp_customize->add_setting('idx_plugin_custom[idx_text_button1_search_bar]', array('capability' => 'edit_theme_options', 'default' => "I'm looking to buy", 'sanitize_callback' => 'sanitize_text_field',));
        $wp_customize->add_control('idx_plugin_custom[idx_text_button1_search_bar]', array('type' => 'text', 'section' => 'idx_plugin_customizer_scheme', 'label' => __('Firts Button'), 'settings' => 'idx_plugin_custom[idx_text_button1_search_bar]',));
        $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_text_button1_search_bar]', array('selector' => '.idx_text_button1_search_bar', 'render_callback' => array($wp_customize, '_idx_text_button1_search_bar'), 'container_inclusive' => true,));

        $wp_customize->add_setting('idx_plugin_custom[idx_text_button2_search_bar]', array('capability' => 'edit_theme_options', 'default' => "I'm looking to sell", 'sanitize_callback' => 'sanitize_text_field',));
        $wp_customize->add_control('idx_plugin_custom[idx_text_button2_search_bar]', array('type' => 'text', 'section' => 'idx_plugin_customizer_scheme', 'label' => __('Second Button'), 'settings' => 'idx_plugin_custom[idx_text_button2_search_bar]',));
        $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_text_button2_search_bar]', array('selector' => '.idx_text_button2_search_bar', 'render_callback' => array($wp_customize, '_idx_text_button2_search_bar'), 'container_inclusive' => true,));


        $wp_customize->add_setting('idx_plugin_custom[idx_link_button1_search_bar]', array('capability' => 'edit_theme_options', 'default' => '#', 'sanitize_callback' => 'sanitize_text_field',));
        $wp_customize->add_control('idx_plugin_custom[idx_link_button1_search_bar]', array('type' => 'text', 'section' => 'idx_plugin_customizer_scheme', 'label' => __('Firts link Button'), 'settings' => 'idx_plugin_custom[idx_link_button1_search_bar]',));
        $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_link_button1_search_bar]', array('selector' => '.idx_link_button1_search_bar', 'render_callback' => array($wp_customize, '_idx_link_button1_search_bar'), 'container_inclusive' => true,));

        $wp_customize->add_setting('idx_plugin_custom[idx_link_button2_search_bar]', array('capability' => 'edit_theme_options', 'default' => '#', 'sanitize_callback' => 'sanitize_text_field',));
        $wp_customize->add_control('idx_plugin_custom[idx_link_button2_search_bar]', array('type' => 'text', 'section' => 'idx_plugin_customizer_scheme', 'label' => __('Second Link Button'), 'settings' => 'idx_plugin_custom[idx_link_button2_search_bar]',));
        $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_link_button2_search_bar]', array('selector' => '.idx_link_button2_search_bar', 'render_callback' => array($wp_customize, '_idx_link_button2_search_bar'), 'container_inclusive' => true,));
    }
}

// lead submission for buy
if (!function_exists("ib_lead_submission_buy_xhr_fn")) {
    function ib_lead_submission_buy_xhr_fn()
    {
        $response = [];
        $access_token = flex_idx_get_access_token();
        $lead_token = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $client_ip = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $tags = isset($_POST["ib_tags"]) ? trim(strip_tags($_POST["ib_tags"])) : "";
        $recaptcha_response = isset($_POST["recaptcha_response"]) ? trim(strip_tags($_POST["recaptcha_response"])) : "";
        $params = [
            'ib_tags' => $tags,
            'recaptcha_response' => $recaptcha_response,
            "access_token" => $access_token,
            "lead_token" => $lead_token,
            "client_ip" => $client_ip,
            "referer" => $referer,
            "origin" => $origin,
            "agent" => $agent,
            "form_data" => $_POST
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEAD_SUBMISSION_BUY);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($output, true);
        wp_send_json($response);
        exit;
    }
}
// lead submission for rent
if (!function_exists("ib_lead_submission_rent_xhr_fn")) {
    function ib_lead_submission_rent_xhr_fn()
    {
        $response = [];
        $access_token = flex_idx_get_access_token();
        $lead_token = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $client_ip = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $tags = isset($_POST["ib_tags"]) ? trim(strip_tags($_POST["ib_tags"])) : "";
        $recaptcha_response = isset($_POST["recaptcha_response"]) ? trim(strip_tags($_POST["recaptcha_response"])) : "";
        $params = [
            'ib_tags' => $tags,
            'recaptcha_response' => $recaptcha_response,
            "access_token" => $access_token,
            "lead_token" => $lead_token,
            "client_ip" => $client_ip,
            "referer" => $referer,
            "origin" => $origin,
            "agent" => $agent,
            "form_data" => $_POST
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEAD_SUBMISSION_RENT);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($output, true);
        wp_send_json($response);
        exit;
    }
}
// lead submission for sell
if (!function_exists("ib_lead_submission_sell_xhr_fn")) {
    function ib_lead_submission_sell_xhr_fn()
    {
        $response = [];
        $access_token = flex_idx_get_access_token();
        $lead_token = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $client_ip = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $tags = isset($_POST["ib_tags"]) ? trim(strip_tags($_POST["ib_tags"])) : "";
        $recaptcha_response = isset($_POST["recaptcha_response"]) ? trim(strip_tags($_POST["recaptcha_response"])) : "";
        $params = [
            'ib_tags' => $tags,
            'recaptcha_response' => $recaptcha_response,
            "access_token" => $access_token,
            "lead_token" => $lead_token,
            "client_ip" => $client_ip,
            "referer" => $referer,
            "origin" => $origin,
            "agent" => $agent,
            "form_data" => $_POST
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEAD_SUBMISSION_SELL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists("ib_register_quizz_save_fn")) {
    function ib_register_quizz_save_fn()
    {
        $response = [];
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $ch = curl_init();
        $timeline_for_purchase = isset($_POST["timeline_for_purchase"]) ? $_POST["timeline_for_purchase"] : "";
        $mortgage_approved = isset($_POST["mortgage_approved"]) ? $_POST["mortgage_approved"] : "";
        $sell_a_home = isset($_POST["sell_a_home"]) ? $_POST["sell_a_home"] : "";

        $quizz_type = isset($_POST["__quizz_type"]) ? $_POST["__quizz_type"] : "";
        $register_phone_facebook = isset($_POST["register_phone_facebook"]) ? $_POST["register_phone_facebook"] : "";

        $sendParams = [
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            "timeline_for_purchase" => $timeline_for_purchase,
            "mortgage_approved" => $mortgage_approved,
            "sell_a_home" => $sell_a_home,
            "quizz_type" => $quizz_type,
            "register_phone_facebook" => $register_phone_facebook
        ];
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_REGISTER_QUIZZ_SAVE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
    }
}
if (!function_exists('ib_schools_info_xhr_fn')) {
    function ib_schools_info_xhr_fn()
    {
        $lat = isset($_POST["lat"]) ? $_POST["lat"] : null;
        $lng = isset($_POST["lng"]) ? $_POST["lng"] : null;
        $distance = isset($_POST["distance"]) ? $_POST["distance"] : null;
        $params = [
            "parameter" => [
                "range_la_lo" => [
                    "lat" => $lat,
                    "long" => $lng,
                    "distance" => $distance
                ]
            ]
        ];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, IDX_BOOTS_NICHE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $output = curl_exec($ch);
        $response = json_decode($output, true);
        curl_close($ch);
        ob_start();
        if (is_array($response)) {
            ?>

            <!-- starts schools information -->

            <div class="list-details clidxboost-schools-container" id="clidxboost-schools-container">
                <div class="list-amenities show school-list">
                    <h3 class="school-title"><?php echo __("Schools for", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        {{address_short}}, <span>{{address_large}}</span>
                    </h3>
                    <div class="clidxboost-niche-tab-filters">
                        <div class="clidxboost-niche-tab">
                            <button class="active" data-filter="all">
                                <span><?php echo __("All Schools", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                        </div>
                        <div class="clidxboost-niche-tab">
                            <button data-filter="elementary">
                                <span><?php echo __("Elementary", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                        </div>
                        <div class="clidxboost-niche-tab">
                            <button data-filter="middle">
                                <span><?php echo __("Middle", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                        </div>
                        <div class="clidxboost-niche-tab">
                            <button data-filter="high">
                                <span><?php echo __("High", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                        </div>
                    </div>
                    <div class="clidxboost-header-niche">
                        <div class="clidxboost-header-th"><?php echo __("School", IDXBOOST_DOMAIN_THEME_LANG); ?> </div>
                        <div class="clidxboost-header-th"><?php echo __("Rating", IDXBOOST_DOMAIN_THEME_LANG); ?> </div>
                        <div class="clidxboost-header-th"><?php echo __("Grades", IDXBOOST_DOMAIN_THEME_LANG); ?> </div>
                        <div class="clidxboost-header-th"><?php echo __("Safety", IDXBOOST_DOMAIN_THEME_LANG); ?> </div>
                        <div class="clidxboost-header-th"><?php echo __("Distance", IDXBOOST_DOMAIN_THEME_LANG); ?> </div>
                        <div class="clidxboost-header-th"><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    </div>
                    <div class="clidxboost-body-niche">
                        <?php
                        $textAcade = '';
                        $textBest = '';
                        if ($response['success']) {
                            foreach ($response['data'] as $keygeom => $valuegeome) {
                                if (empty($valuegeome['grade_best_school'])) {
                                    $textBest = 'overall-not-graded.png';
                                } else {
                                    $textBest = strtolower($valuegeome['grade_best_school']);
                                    $textBest = str_replace("-", "-minus", $textBest);
                                    $textBest = 'overall-' . str_replace("+", "-plus", $textBest) . '.png';
                                }

                                if (empty($valuegeome['grade_academics_school'])) {
                                    $textAcade = 'overall-not-graded.png';
                                } else {
                                    $textAcade = strtolower($valuegeome['grade_academics_school']);
                                    $textAcade = str_replace("-", "-minus", $textAcade);
                                    $textAcade = 'overall-' . str_replace("+", "-plus", $textAcade) . '.png';
                                }
                                $pathImageBest = 'https://alerts.flexidx.com/img/grades/' . $textBest;
                                $pathImageAca = 'https://alerts.flexidx.com/img/grades/' . $textAcade;
                                $filtextSchool = '';

                                if (strpos($valuegeome['name_school'], 'Elementary')) {
                                    $filtextSchool = 'elementary';
                                } elseif (strpos($valuegeome['name_school'], 'Middle')) {
                                    $filtextSchool = 'elementary';
                                } elseif (strpos($valuegeome['name_school'], 'High')) {
                                    $filtextSchool = 'high';
                                }
                                ?>
                                <div class="clidxboost-td-niche <?php echo $filtextSchool; ?> clidxboost-td-niche-hide">
                                    <div class="clidxboost-data-item">
                                        <a target="blank" rel="nofollow"
                                           href="<?php echo $valuegeome['url']; ?>"><?php echo $valuegeome['name_school']; ?></a>
                                    </div>
                                    <div class="clidxboost-data-item"><img class="clidxboost-rangeSchools"
                                                                           src="<?php echo $pathImageBest; ?>"></div>
                                    <div class="clidxboost-data-item"><?php echo $valuegeome['grades_offered']; ?></div>
                                    <div class="clidxboost-data-item"><img class="clidxboost-safelySchools"
                                                                           src="<?php echo $pathImageAca; ?> "></div>
                                    <div class="clidxboost-data-item"><?php echo number_format(($valuegeome['distancePoint'] * 0.62137), 1, '.', ''); ?><?php echo __("Miles", IDXBOOST_DOMAIN_THEME_LANG); ?> </div>
                                    <div class="clidxboost-data-item"><?php echo $valuegeome['character']; ?></div>
                                </div>
                            <?php }
                        }
                        ?>
                        <div id="clidxboost-container-loadMore-niche" class="clidxboost-container-loadMore-niche">
                            <div class="clidxboost-count-niche"><?php echo $response["count"]; ?><?php echo __("more schools", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                            <div id="clidxboost-data-loadMore-niche"><?php echo __("Expand", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                        </div>
                        <div class="uc-listingSchools-disclaimer">
                            <p>
                                <a class="uc-listingSchools-attributionLink" href="https://www.niche.com/k12"
                                   target="_blank">
                                    <?php echo __("K12 School Data", IDXBOOST_DOMAIN_THEME_LANG); ?>
                                </a>
                                <?php echo __("provided by", IDXBOOST_DOMAIN_THEME_LANG); ?>
                                <a href="//www.niche.com/" target="_blank">
                                    <svg id="niche-logotype" viewBox="0 0 501.59 76.61" width="100%" height="100%">
                                        <path d="M418.36 17.89a34.14 34.14 0 0 0 6.31 3.89 37.4 37.4 0 0 0 18 3.91c6.54-.25 12.5-2.45 18-4.68 4.44-1.78 9.65-3.69 15.25-3.69h1.55a33.94 33.94 0 0 1 14.33 4.58 29.47 29.47 0 0 1 5.46 3.77 3 3 0 0 0 2 .79 2.26 2.26 0 0 0 2.08-1.34 2.48 2.48 0 0 0-.18-2.39 5.25 5.25 0 0 0-1.14-1.21l-.1-.08a38.92 38.92 0 0 0-6-3.87 39.74 39.74 0 0 0-17.6-4.8c-6.4-.19-12.34 1.79-17.79 4l-.14.06c-5.37 2.15-10.93 4.37-17 4.45h-.37a31 31 0 0 1-19.81-7.42 2.47 2.47 0 0 0-2-.56 2.35 2.35 0 0 0-1.67 1.08 2.68 2.68 0 0 0 0 2.58 3.54 3.54 0 0 0 .82.93zM418.36 37.55a34.34 34.34 0 0 0 6.31 3.89 37.26 37.26 0 0 0 18 3.91c6.52-.25 12.49-2.45 18-4.68 4.44-1.78 9.64-3.69 15.25-3.69h1.55a33.94 33.94 0 0 1 14.33 4.59 29.57 29.57 0 0 1 5.46 3.77 3 3 0 0 0 2 .79 2.26 2.26 0 0 0 2.08-1.34 2.44 2.44 0 0 0-.18-2.39 5.26 5.26 0 0 0-1.14-1.21l-.1-.08a39.05 39.05 0 0 0-6-3.87 39.75 39.75 0 0 0-17.6-4.8c-6.41-.2-12.34 1.79-17.79 4l-.15.06c-5.37 2.15-10.92 4.37-17 4.45h-.36a31 31 0 0 1-19.82-7.42 2.47 2.47 0 0 0-2-.56 2.35 2.35 0 0 0-1.67 1.07 2.68 2.68 0 0 0 0 2.59 3.59 3.59 0 0 0 .83.92zM500.04 60.84l-.1-.08a38.89 38.89 0 0 0-6-3.87 39.75 39.75 0 0 0-17.6-4.8c-6.42-.19-12.34 1.79-17.79 4l-.15.06c-5.37 2.15-10.92 4.37-17 4.45h-.37a31 31 0 0 1-19.81-7.43 2.45 2.45 0 0 0-2-.56 2.35 2.35 0 0 0-1.67 1.07 2.68 2.68 0 0 0 0 2.59 3.56 3.56 0 0 0 .83 1 34.3 34.3 0 0 0 6.31 3.89 37.23 37.23 0 0 0 18 3.91c6.54-.25 12.5-2.45 18-4.68 4.45-1.78 9.66-3.69 15.25-3.69h1.55a34 34 0 0 1 14.31 4.53 29.35 29.35 0 0 1 5.46 3.76 3 3 0 0 0 2 .79 2.26 2.26 0 0 0 2.08-1.34 2.47 2.47 0 0 0-.18-2.39 5.25 5.25 0 0 0-1.12-1.21zM398.18 8.64A39.3 39.3 0 0 0 365.59.8a38.27 38.27 0 0 0-2.65 74.3 37.26 37.26 0 0 0 10.54 1.5 39.81 39.81 0 0 0 22.58-7.09A38.68 38.68 0 0 0 412.3 38.3a38.48 38.48 0 0 0-14.12-29.66zm9.38 29.66a34.85 34.85 0 0 1-14.19 27.8 34 34 0 1 1-19.44-61.94h1.49a34.07 34.07 0 0 1 32.14 34.14z"></path>
                                        <path d="M389.36 17.69a2.5 2.5 0 0 0-2.49 2.49v29.71L360.4 18.51a2.32 2.32 0 0 0-2.14-.82 2.49 2.49 0 0 0-2.49 2.49v36.79a2.5 2.5 0 0 0 5 0V27.04l26.57 31.5a2.26 2.26 0 0 0 1 .69 2.46 2.46 0 0 0 1 .24 2.5 2.5 0 0 0 2.49-2.49v-36.8a2.5 2.5 0 0 0-2.47-2.49zM81.46 5.99c-2 0-3.54 1.19-3.54 4.18v56.42a3.54 3.54 0 0 0 7.07 0V10.25c0-2.95-1.58-4.26-3.53-4.26zM52.61 5.99c-2 0-3.54 1.19-3.54 4.18V56.3L6.55 7.37a3.25 3.25 0 0 0-1-.78 3.4 3.4 0 0 0-2-.64c-2 0-3.54 1.19-3.54 4.18v56.42a3.54 3.54 0 0 0 7.07 0V18.21L49.8 68.88a3.27 3.27 0 0 0 1.88 1.1 3.49 3.49 0 0 0 4.45-3.4V10.25c.01-2.95-1.57-4.26-3.52-4.26zM234.5 5.99c-2 0-3.53 1.19-3.53 4.18v24.44h-42V10.25c0-2.91-1.58-4.26-3.53-4.26h-.08c-2 0-3.53 1.19-3.53 4.18v56.42a3.54 3.54 0 0 0 3.53 3.53h.08a3.53 3.53 0 0 0 3.53-3.53v-26h42v26a3.535 3.535 0 0 0 7.07 0V10.25c0-2.95-1.58-4.26-3.54-4.26zM124.96 13.78c10.1-5.06 22.05-2.17 29.77 5.71a3.84 3.84 0 0 0 5.31.45 3.36 3.36 0 0 0 0-4.93c-9.51-9.71-23.66-12.35-36.27-7.78-11 4-19.16 14.57-20.7 26.1a32.73 32.73 0 0 0 13.32 30.7 34.05 34.05 0 0 0 36.41 1.85 33.57 33.57 0 0 0 6.45-4.83c1.77-1.68.85-4-.61-5.08a3.59 3.59 0 0 0-4.66.6 25.8 25.8 0 0 1-29.6 4.61c-9.07-4.54-14.29-14.31-14.17-24.27a26.6 26.6 0 0 1 14.75-23.13zM307.27 11.95c2.45 0 3.59-1.33 3.59-3s-1-3-3.52-3h-43.31c-2 0-3.53 1.19-3.53 4.18v56.42a3.54 3.54 0 0 0 3.53 3.53h43.24c2.45 0 3.59-1.33 3.59-3s-1-3-3.52-3h-39.7V40.56h32c2.45 0 3.59-1.33 3.59-3s-1-3-3.51-3h-32.07V11.95zM325.74 20.01a7 7 0 1 1 7-7 7 7 0 0 1-7 7zm0-13.1a6.14 6.14 0 1 0 6 6.1 6.1 6.1 0 0 0-6-6.11z"></path>
                                        <path d="M326.66 13.4a2.11 2.11 0 0 0 2-2.22 2.25 2.25 0 0 0-2.13-2.25h-2.75a.38.38 0 0 0-.38.46.87.87 0 0 0 0 .1v7.08c0 .5.12.65.46.65s.44-.17.44-.65v-3.14h1.49l1.58 3.15s.34.76.75.55 0-.94 0-.94zm-2.41-3.71h2.11a1.47 1.47 0 0 1 1.35 1.48 1.45 1.45 0 0 1-1.31 1.46h-2.15z"></path>
                                    </svg>
                                </a>
                            </p>
                            <p>
                                <?php echo __("School data provided as-is by", IDXBOOST_DOMAIN_THEME_LANG); ?>
                                <a class="uc-listingSchools-disclaimerLink" href="https://www.niche.com"
                                   target="_blank">
                                    Niche</a>,
                                <?php echo __("a third party. It is the responsibility of the user to evaluate all sources of information. Users should visit all school district web sites and visit all the schools in person to verify and consider all data, including eligibility.", IDXBOOST_DOMAIN_THEME_LANG); ?>
                            </p>
                        </div>
                    </div>
                    <div class="idxboost-line-properties"></div>
                </div>
            </div>

            <!-- ends schools information -->

            <?php
        } else {
            echo "";
        }
        $output = ob_get_clean();
        $response["output"] = $output;
        //echo $output;
        wp_send_json($response);
        exit;
    }
}

//EN STAGING NO
if (!function_exists('iboost_print_googlegtm_head_script')) {
    function iboost_print_googlegtm_head_script()
    {

        $idx_boost_setting = FLEX_IDX_PATH . 'feed/idx_boost_setting.json';
        $environment_deco = [];
        if (file_exists($idx_boost_setting)) {
            $environment = file_get_contents($idx_boost_setting);
            if (!empty($environment)) {
                $environment_deco = json_decode($environment, true);
            }

            if (is_array($environment_deco) && array_key_exists('status', $environment_deco) && $environment_deco['status'] != false) {
                if ($environment_deco['environment'] == 'production') {

                    global $flex_idx_info;
                    if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) {
                        ?>
                        <!-- Google Tag Manager -->
                        <script>
                            (function (w, d, s, l, i) {
                                w[l] = w[l] || [];
                                w[l].push({
                                    'gtm.start': new Date().getTime(),
                                    event: 'gtm.js'
                                });
                                var f = d.getElementsByTagName(s)[0],
                                    j = d.createElement(s),
                                    dl = l != 'dataLayer' ? '&l=' + l : '';
                                j.async = true;
                                j.src =
                                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                                f.parentNode.insertBefore(j, f);
                            })(window, document, 'script', 'dataLayer', '<?php echo $flex_idx_info['agent']['google_gtm']; ?>');
                        </script>
                        <!-- End Google Tag Manager -->
                        <?php
                    }
                }
            }
        }
    }
}

//EN STAGING NO
if (!function_exists('iboost_print_googlegtm_body_script')) {
    function iboost_print_googlegtm_body_script()
    {

        $idx_boost_setting = FLEX_IDX_PATH . 'feed/idx_boost_setting.json';
        $environment_deco = [];
        if (file_exists($idx_boost_setting)) {
            $environment = file_get_contents($idx_boost_setting);
            if (!empty($environment)) {
                $environment_deco = json_decode($environment, true);
            }

            if (is_array($environment_deco) && array_key_exists('status', $environment_deco) && $environment_deco['status'] != false) {
                if ($environment_deco['environment'] == 'production') {

                    global $flex_idx_info;
                    if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) { ?>
                        <!-- Google Tag Manager (noscript) -->
                        <noscript>
                            <iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $flex_idx_info['agent']['google_gtm']; ?>"
                                    height="0" width="0" style="display:none;visibility:hidden"></iframe>
                        </noscript>
                        <!-- End Google Tag Manager (noscript) -->
                        <?php
                    }
                }
            }
        }
    }
}


if (!function_exists('iboost_print_analytics_script')) {
    function iboost_print_analytics_script()
    {
        global $flex_idx_info;
        if ((!empty($flex_idx_info["agent"]["google_analytics"])) && (!empty($flex_idx_info["agent"]["google_adwords"]))) {
            printf('<script async src="//googletagmanager.com/gtag/js?id=%s"></script>', $flex_idx_info["agent"]["google_analytics"]);
            echo '<script>';
            echo 'var iboost_track_gid = true;';
            echo 'window.dataLayer = window.dataLayer || [];';
            echo 'function gtag() { dataLayer.push(arguments); }';
            echo 'gtag("js", new Date());';
            echo 'gtag("config", "' . $flex_idx_info["agent"]["google_analytics"] . '");';
            echo 'gtag("config", "' . $flex_idx_info["agent"]["google_adwords"] . '");';
            echo 'var ibost_g_config_analytics = "' . $flex_idx_info["agent"]["google_analytics"] . '";';
            echo 'var ibost_g_config_adwords = "' . $flex_idx_info["agent"]["google_adwords"] . '"';
            echo '</script>';
        }
    }
}
if (!function_exists('iboost_load_property_xhr_fn')) {
    function iboost_load_property_xhr_fn()
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;
        $access_token = flex_idx_get_access_token();
        $search_params = $flex_idx_info['search'];
        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        $mls_num = isset($_POST["mlsNumber"]) ? trim($_POST["mlsNumber"]) : "";
        $wp_request = $wp->request;
        // $wp_request_exp = explode('/', $wp_request);
        // list($page, $slug) = $wp_request_exp;
        // if (strstr($slug, '-rx-')) {
        //     $exp_slug = explode('-', $slug);
        //     $mls_num  = 'rx-' . end($exp_slug);
        // } else {
        //     $exp_slug = explode('-', $slug);
        //     $mls_num  = end($exp_slug);
        // }
        $type_lookup = 'active';
        $prefix_property_slug = "/";
        // if (preg_match('/^sold\-(.*)/', $slug)) {
        //     $type_lookup = 'sold';
        //              $prefix_property_slug = "/sold-";
        // } else if (preg_match('/^rented\-(.*)/', $slug)) {
        //     $type_lookup = 'rent';
        //              $prefix_property_slug = "/rented-";
        // } else if (preg_match('/^pending\-(.*)/', $slug)) {
        //     $type_lookup = 'pending';
        //              $prefix_property_slug = "/pending-";
        // } else {
        //     $type_lookup = 'active';
        //              $prefix_property_slug = "/";
        // }
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $sendParams = array(
            'mls_num' => $mls_num,
            'type_lookup' => $type_lookup,
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data' => array(
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'user_agent' => $user_agent,
            ),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LOOKUP);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        $current_url = home_url($wp_request);
        $property = (isset($response['success']) && $response['success'] === true) ? $response['payload'] : array();
        //wp_enqueue_script('flex-idx-property-js');
        $agent_info_name = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';
        $property_permalink = rtrim($flex_idx_info['pages']['flex_idx_property_detail']['guid'], "/") . $prefix_property_slug . $property['slug'];
        // build facebook url share
        $site_title = get_bloginfo('name');
        $facebook_share_url = '//facebook.com/sharer/sharer.php';
        $facebook_share_params = http_build_query(array(
            'u' => $property_permalink,
            'picture' => $property['gallery'][0],
            'title' => $property['address_short'] . ' ' . $property['address_large'],
            'caption' => $site_title,
            'description' => $property['remark'],
        ));
        $facebook_share_url .= '?' . $facebook_share_params;
        // build twitter url share
        $twitter_text = $property['address_short'] . ' ' . $property['address_large'];
        $twitter_share_url_params = http_build_query(array(
            'text' => $twitter_text,
            'url' => $property_permalink,
        ));
        $twitter_share_url = '//twitter.com/intent/tweet?' . $twitter_share_url_params;
        $agent_info = get_option('idxboost_agent_info');
        $registration_is_forced = (isset($agent_info["force_registration"]) && (true === $agent_info["force_registration"])) ? true : false;
        ob_start();
        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_property_modal_detail.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_property_modal_detail.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/flex_idx_property_modal_detail.php';
        }
        $output = ob_get_clean();
        echo $output;
        exit;
    }
}
if (!function_exists('iboost_try_save_filter_xhr_fn')) {
    function iboost_try_save_filter_xhr_fn()
    {
        global $wpdb;
        $referrerUrl = isset($_POST["referrerUrl"]) ? trim(strip_tags($_POST["referrerUrl"])) : "";
        $response = [];
        if ("" !== $referrerUrl) {
            $filter_post_name = trim(parse_url($referrerUrl, PHP_URL_PATH), "/");
            $filter_options = $wpdb->get_row("
      select t1.ID, t1.post_name, t1.post_title, t1.guid, t2.meta_value AS filter_ID
      from {$wpdb->posts} t1
      inner join {$wpdb->postmeta} t2
      on t1.ID = t2.post_id
      where post_type = 'flex-filter-pages' and post_status = 'publish' and post_name = 'miami-beach-homes' and t2.meta_key = '_flex_filter_page_id'
      limit 1
      ", ARRAY_A);
            if (!empty($filter_options)) {
                $response["search_url"] = $referrerUrl;
                $response["action"] = "idxboost_filter_save_search";
                $response["search_count"] = 0;
                $response["name"] = $filter_options["post_title"];
                $response["notification_day"] = 1;
                $response["notification_type"] = array("new_listing", "price_change", "status_change");
                $response["search_query"] = "";
                $response["wp_object"] = $filter_options;
            }
        }
        wp_send_json($response);
    }
}
if (!function_exists('idx_boots_main_css')) {
    function idx_boots_main_css()
    {
        wp_enqueue_style('flex-idx-main-project');
    }
}

if (!function_exists('idx_boost_cms_assets_style')) {
    function idx_boost_cms_assets_style()
    {
        global $flex_idx_info, $post, $wp;

        $idx_page_id = get_post_meta($post->ID, 'idx_page_id', true);
        $idx_page_type = get_post_meta($post->ID, 'idx_page_type', true);

        if (!empty($flex_idx_info['agent']['has_cms']) && $flex_idx_info['agent']['has_cms'] != false) {

            $GLOBALS["crm_theme_setting"] = [];

            $data_service = array(
                'registration_key' => get_option('idxboost_registration_key')
            );

            if ($idx_page_id) {
                $data_service['page_id'] = $idx_page_id;
            }

            $payload_json = json_encode($data_service);

            $curl_service = curl_init();
            curl_setopt_array($curl_service, array(
                CURLOPT_URL => IDX_BOOST_SPW_BUILDER_SERVICE . '/api/theme-settings',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $payload_json,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/plain'
                ),
            ));

            $response_service = curl_exec($curl_service);
            curl_close($curl_service);

            $head_json = @json_decode($response_service, true);

            // Load font setting
            if (is_array($head_json) && count($head_json) > 0) {
                $GLOBALS["crm_theme_setting"] = $head_json;

                if (array_key_exists("font", $head_json)) {
                    echo trim($head_json['font']);
                }
            }

            echo '<link rel="stylesheet" id="idx_boost_style_base-css" href="' . IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/css/base.css' . '" type="text/css" media="all">';

            if (
                is_home() ||
                is_front_page() ||
                $idx_page_type == 'custom' ||
                $idx_page_type == 'landing'
            ) {
                echo '<link rel="stylesheet" id="idx_boost_style_home-css" href="' . IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/css/home.css' . '" type="text/css" media="all">';
            }

            if ($post->post_type == 'flex-idx-pages') {
                $type_filter = get_post_meta($post->ID, '_flex_id_page', true);

                if ($type_filter == "flex_idx_page_about") {
                    echo '<link rel="stylesheet" id="idx_boost_style_about-css" href="' . IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/css/about.css' . '" type="text/css" media="all">';
                }

                if ($type_filter == "flex_idx_page_contact") {
                    echo '<link rel="stylesheet" id="idx_boost_style_contact-css" href="' . IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/css/contact.css' . '" type="text/css" media="all">';
                }

                if ($type_filter == "flex_idx_page_team") {
                    echo '<link rel="stylesheet" id="idx_boost_style_team-css" href="' . IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/css/team.css' . '" type="text/css" media="all">';
                }
            }

            if ($post->post_type == 'idx-agents') {
                wp_enqueue_script('idx_boost_js_contact', IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/js/agent.js', array(), false, true);
            }

            // Load loader

            if (is_array($head_json) && count($head_json) > 0) {
                if (
                    array_key_exists("loader", $head_json) &&
                    array_key_exists("content", $head_json['loader'])
                ) {
                    update_option("cms_loader", trim($head_json['loader']['content']));
                }
            }

            // Load custom style

            if (is_array($head_json) && count($head_json) > 0) {
                if (array_key_exists("globalCss", $head_json)) {
                    update_option("cms_custom_style", trim($head_json['globalCss']));
                }
            }
        }

        if (get_option("favicon")) {
            echo '<link rel="shortcut icon" href="' . get_bloginfo('wpurl') . '/' . get_option("favicon") . '" />';
        }
    }
}

if (!function_exists('idxboost_cms_custom_style')) {
    function idxboost_cms_custom_style()
    {
        if (get_option("cms_custom_style")) {
            echo '<style type="text/css">' . get_option("cms_custom_style") . '</style>';
        }
    }
}

if (!function_exists('idxboost_cms_loader')) {
    function idxboost_cms_loader()
    {
        echo get_option("cms_loader");
    }
}

if (!function_exists('idxboost_cms_tripwire')) {
    function idxboost_cms_tripwire()
    {
        global $flex_idx_info;

        if (
            ! empty($flex_idx_info['agent']['has_cms']) &&
            $flex_idx_info['agent']['has_cms'] != false
        ) {

            $response = wp_remote_post(
                IDX_BOOST_SPW_BUILDER_SERVICE . '/api/tripwires-default',
                array(
                    'method' => 'POST',
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'body' => wp_json_encode(array(
                        'registration_key' => get_option('idxboost_registration_key')
                    ))
                )
            );

            $body = wp_remote_retrieve_body($response);
            $content = json_decode($body, true);

            if ( !is_wp_error($response) or $content != NULL ) {
                
                if ( $content['data']['applyTo'] == 'entire-site' ) {
                    echo $content['content'];
                }

                if ( $content['data']['applyTo'] == 'home' ) {
                    if ( is_home() || is_front_page() ) {
                        echo $content['content'];
                    }
                }

            }

        }
    }
}

if (!function_exists('grab_image')) {
    function grab_image($url, $saveto)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        $raw = curl_exec($ch);
        curl_close($ch);
        if (file_exists($saveto)) {
            unlink($saveto);
        } else {
            $dirname = dirname($saveto);
            if (!is_dir($dirname)) {
                mkdir($dirname, 0755, true);
            }
        }
        $fp = fopen($saveto, 'x');
        fwrite($fp, $raw);
        fclose($fp);
    }
}
if (!function_exists('flex_has_filter_url_params')) {
    function flex_has_filter_url_params()
    {
        if (isset($_GET["ibtrack"]) && ("fp" === $_GET["ibtrack"])) {
            return true;
        }
        return false;
    }
}
if (!function_exists('flex_get_filter_url_params')) {
    function flex_get_filter_url_params()
    {
        $parameters = array();
        $valid_parameters = array("price", "bed", "bath", "type", "sqft", "lotsize", "yearbuilt", "waterdesc", "parking", "features", "view", "sort", "pagenum");
        $GET_parameters = array_filter($_GET);
        foreach ($GET_parameters as $key => $value) {
            if (!in_array($key, $valid_parameters)) {
                continue;
            }
            $parameters[$key] = $value;
        }
        return empty($parameters) ? "" : json_encode($parameters);
    }
}
if (!function_exists('flex_idx_skip_import_data_fn')) {
    function flex_idx_skip_import_data_fn()
    {
        $response = array("success" => true, "message" => "OK");
        add_option('idxboost_import_initial_data', 'yes');
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('idxboost_attach_image_to_post')) {
    function idxboost_attach_image_to_post($image_src, $post_id)
    {
        $wp_upload_dir = wp_upload_dir();
        $post_base_dir = $wp_upload_dir['basedir'];
        $path_save = $wp_upload_dir['path'] . '/' . basename($image_src);
        grab_image($image_src, $path_save);
        // attach image to post in wordpress
        $filename = $path_save;
        $filetype = wp_check_filetype(basename($filename), null);
        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)) . '_thumb_' . uniqid(),
            'post_content' => '',
            'post_status' => 'inherit',
        );
        $attach_id = wp_insert_attachment($attachment);
        // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        // Generate the metadata for the attachment, and update the database record.
        $filepath = trim($wp_upload_dir['subdir'] . '/' . basename($filename), '/');
        add_post_meta($attach_id, '_wp_attached_file', $filepath, true);
        $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($post_id, $attach_id);
    }
}
if (!function_exists('dgt_mortgage_calculator_fn')) {
    function dgt_mortgage_calculator_fn()
    {
        $params = $_POST;
        if (isset($params['action'])) {
            $sale_price = (float)sanitize_text_field($params['purchase_price']);
            $down_percent = sanitize_text_field($params['down_payment']);
            $year_term = sanitize_text_field($params['year_term']);
            $annual_interest_percent = sanitize_text_field($params['interest_rate']);
            if (!is_numeric($sale_price) || !is_numeric($down_percent) || !is_numeric($annual_interest_percent)) {
                header('HTTP/1.1 500 Invalid number!');
                exit();
            }
            $response = calculateMortgage($sale_price, $down_percent, $year_term, $annual_interest_percent);
            echo wp_send_json($response);
            exit();
        }
    }
}
if (!function_exists('calculateMortgage')) {
    function calculateMortgage($sale_price, $down_percent, $year_term, $annual_interest_percent)
    {
        $monthly_factor = 0;
        $month_term = $year_term * 12;
        $down_payment = $sale_price * ($down_percent / 100);
        $annual_interest_rate = $annual_interest_percent / 100;
        $monthly_interest_rate = $annual_interest_rate / 12;
        $financing_price = $sale_price - $down_payment;
        $base_rate = 1 + $monthly_interest_rate;
        $denominator = $base_rate;
        for ($i = 0; $i < ($year_term * 12); $i++) {
            $monthly_factor += (1 / $denominator);
            $denominator *= $base_rate;
        }
        $monthly_payment = $financing_price / $monthly_factor;
        $pmi_per_month = 0;
        if ($down_percent < 20) {
            $pmi_per_month = 55 * ($financing_price / 100000);
        }
        $total_monthly = $monthly_payment + $pmi_per_month; // + $residential_monthly_tax;
        $output = array(
            'mortgage' => number_format($financing_price, 0),
            'down_payment' => number_format($down_payment, 0),
            'monthly' => number_format($monthly_payment, 2),
            'total_monthly' => number_format($total_monthly, 2)
        );
        return $output;
    }
}
if (!function_exists('flex_schedule_showing_fn')) {
    function flex_schedule_showing_fn()
    {
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $client_ip = get_client_ip_server();
        $url_referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $url_origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $mls_number = isset($_POST['mls_number']) ? $_POST['mls_number'] : null;
        $permalink = isset($_POST['permalink']) ? $_POST['permalink'] : null;
        $address_short = isset($_POST['address_short']) ? $_POST['address_short'] : null;
        $address_large = isset($_POST['address_large']) ? $_POST['address_large'] : null;
        $slug = isset($_POST['slug']) ? $_POST['slug'] : null;
        $price = isset($_POST['price']) ? $_POST['price'] : null;
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : null;
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
        $email_address = isset($_POST['email_address']) ? $_POST['email_address'] : null;
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : null;
        $comments = isset($_POST['comments']) ? $_POST['comments'] : null;
        $preferred_time = isset($_POST['preferred_time']) ? $_POST['preferred_time'] : null;
        $preferred_date = isset($_POST['preferred_date']) ? $_POST['preferred_date'] : null;
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data' => array(
                'client_ip' => $client_ip,
                'url_referer' => $url_referer,
                'url_origin' => $url_origin,
                'user_agent' => $user_agent,
                'mls_number' => $mls_number,
                'permalink' => $permalink,
                'address_short' => $address_short,
                'address_large' => $address_large,
                'slug' => $slug,
                'price' => $price,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email_address' => $email_address,
                'phone_number' => $phone_number,
                'comments' => $comments,
                'preferred_time' => $preferred_time,
                'preferred_date' => $preferred_date
            ),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SCHEDULE_SHOWING_FORM);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_share_with_friend_xhr_fn')) {
    function flex_share_with_friend_xhr_fn()
    {
        global $wpdb;
        $response = array();
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $permalink = isset($_POST['share_permalink']) ? trim(strip_tags($_POST['share_permalink'])) : '';
        $share_type = isset($_POST['share_type']) ? trim(strip_tags($_POST['share_type'])) : null;
        $building_ID = isset($_POST['building_ID']) ? trim(strip_tags($_POST['building_ID'])) : null;
        $mls_num = isset($_POST['mls_num']) ? trim(strip_tags($_POST['mls_num'])) : null;
        $type_property = isset($_POST['type_property']) ? trim(strip_tags($_POST['type_property'])) : null;
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $friend_email = isset($_POST['friend_email']) ? trim(strip_tags($_POST['friend_email'])) : '';
        $friend_name = isset($_POST['friend_name']) ? trim(strip_tags($_POST['friend_name'])) : '';
        $your_name = isset($_POST['your_name']) ? trim(strip_tags($_POST['your_name'])) : '';
        $your_email = isset($_POST['your_email']) ? trim(strip_tags($_POST['your_email'])) : '';
        $comments = isset($_POST['comments']) ? trim(strip_tags($_POST['comments'])) : '';
        $recaptcha_response = isset($_POST["recaptcha_response"]) ? trim(strip_tags($_POST["recaptcha_response"])) : "";
        $sendParams = array(
            'access_token' => $access_token,
            'recaptcha_response' => $recaptcha_response,
            'flex_credentials' => $flex_lead_credentials,
            'data' => array(
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'user_agent' => $user_agent,
                'permalink' => $permalink,
                'share_type' => $share_type,
                'friend_email' => $friend_email,
                'friend_name' => $friend_name,
                'your_name' => $your_name,
                'your_email' => $your_email,
                'comments' => $comments,
            ),
        );
        if ($share_type == 'building') {
            $sendParams['data']['building_ID'] = $building_ID;
            $sendParams['data']['type_property'] = $type_property;
        } elseif ($share_type == 'property') {
            $sendParams['data']['mls_num'] = $mls_num;
            $sendParams['data']['type_property'] = $type_property;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SHARE_TO_FRIEND);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('idx_import_tgbuilding_update_xhr_fn')) {
    function idx_import_tgbuilding_update_xhr_fn()
    {
        global $wpdb;

        $response = ['status' => false, 'message' => 'You need install TgBuilding'];

        if (function_exists('feed_file_building')) {
            $response['data'] = feed_file_building();
            $response['status'] = true;
            $response['message'] = 'success update!!';
        }
        return $response;
    }
}

if (!function_exists('idxboost_import_building_xhr_fn')) {
    function idxboost_import_building_xhr_fn()
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;
        $access_token = flex_idx_get_access_token();
        $page = isset($_POST['page']) ? trim(strip_tags($_POST['page'])) : 0;
        $estruct_insert_page = "INSERT INTO wp_posts(post_title,post_type,post_status,post_mime_type,post_name) values";
        $wp_postmeta_insert = "INSERT INTO wp_postmeta(post_id,meta_key,meta_value) values";
        $struct_table_relationship = 'INSERT into wp_term_relationships(object_id,term_taxonomy_id,term_order) values';
        $struct_update_relationship = "UPDATE wp_term_relationships set  term_taxonomy_id = CASE ";

        $estruct_update_postmeta = "UPDATE wp_postmeta set  meta_value = CASE ";
        $estruct_update_wppost = "UPDATE wp_posts set  post_title = CASE ";

        $list_building_id = [];
        $insert_pages_idxboost = [];
        $update_relationship_cate = [];
        $meta_insert = [];
        $title_update = [];

        $meta_update['tgbuilding_url'] = array('query' => []);
        $meta_update['dgt_extra_address'] = array('query' => []);
        $meta_update['dgt_extra_lat'] = array('query' => []);
        $meta_update['dgt_extra_lng'] = array('query' => []);
        $meta_update['dgt_year_building'] = array('query' => []);
        $meta_update['dgt_extra_floor'] = array('query' => []);
        $meta_update['dgt_extra_unit'] = array('query' => []);
        $meta_update['dgt_tg_idxboost_building'] = array('query' => []);
        $meta_update['dgt_tg_gallery'] = array('query' => []);


        $code_existing = '123456789';
        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $categorys_loop = $wpdb->get_results("SELECT {$wpdb->terms}.slug,{$wpdb->terms}.term_id FROM {$wpdb->term_taxonomy} INNER JOIN {$wpdb->terms} ON {$wpdb->terms}.term_id={$wpdb->term_taxonomy}.term_id AND {$wpdb->term_taxonomy}.taxonomy='category_building';", ARRAY_A);

        $result_tgbuilding_wp = $wpdb->get_results("SELECT post.ID,post.post_title as name,meta.meta_value as code FROM {$wpdb->posts} post inner join {$wpdb->postmeta} as meta on meta.post_id=post.ID and meta.meta_key='dgt_tg_idxboost_building'  where post_type='tgbuilding';", ARRAY_A);

        $result_slug_buildings = $wpdb->get_results("
            SELECT post.ID,post.post_title as name,meta.meta_value as code ,post.post_name as path_building
            FROM {$wpdb->posts} post 
                inner join {$wpdb->postmeta} as meta on meta.post_id=post.ID and meta.meta_key='_flex_building_page_id' 
            where post_type='flex-idx-building' and post.post_status='publish';", ARRAY_A);

        $list_term_slug = [];
        $list_term_id = [];
        $columns_category = [];
        $result_item_cat_rela = [];
        $list_building_wp = [];

        if (is_array($result_tgbuilding_wp) && count($result_tgbuilding_wp) > 0) {

            $list_building_wp = array_column($result_tgbuilding_wp, 'code');

            if (is_array($categorys_loop) && count($categorys_loop) > 0) {

                $list_term_slug = array_column($categorys_loop, 'slug');
                $list_term_id = array_column($categorys_loop, 'term_id');
                $result_item_cat_rela = $wpdb->get_results("SELECT object_id as post_id,term_taxonomy_id as category_id FROM wp_term_relationships where term_taxonomy_id in (" . implode(',', $list_term_id) . ");", ARRAY_A);
                $columns_category = array_column($result_item_cat_rela, 'post_id');
            }
        }

        //$result_idxbuilding_wp=$wpdb->get_results("SELECT post.ID,post.post_title as name,meta.meta_value as code FROM wp_work.wp_posts post inner join wp_work.wp_postmeta as meta on meta.post_id=post.ID and meta.meta_key='_flex_building_page_id'  where post_type='flex-idx-building';",ARRAY_A);

        $wp_request = $wp->request;
        $wp_request_exp = explode('/', $wp_request);
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'page' => $page,
            'existing_code' => $code_existing
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDING_IMPORT);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        $response = json_decode($server_output, true);
        curl_close($ch);
        $response_data_new_items = [];

        $status_data = false;
        if ($response['status'] != false) {

            $status_data = true;

            $building_slug = $wpdb->get_var("SELECT t1.post_name
            FROM {$wpdb->posts} t1
          inner join {$wpdb->postmeta} t2
          on t1.ID = t2.post_id
          where t1.post_type = 'flex-idx-pages'
              and t1.post_status = 'publish'
              and t2.meta_key = '_flex_id_page'
              and t2.meta_value = 'flex_idx_building'
          limit 1
          ");

            if (empty($building_slug) || $building_slug == '')
                $building_slug = 'building';


            foreach ($response['item'] as $value_item) {

                $key_exist_tgbuilding = array_search($value_item['codBuilding'], $list_building_wp);

                if (!empty($value_item['codBuilding'])) {

                    $GLOBALS["codeBuilding"] = $value_item['codBuilding'];

                    $slug_building_exist =
                        array_values(
                            array_filter($result_slug_buildings, function ($sent) {
                                return ($sent['code'] == $GLOBALS["codeBuilding"]);
                            })
                        );
                }

                $path_building = '';

                if (is_array($slug_building_exist) && count($slug_building_exist) > 0) {
                    $path_building = $slug_building_exist[0]['path_building'];
                } else {
                    $path_building = generar_url_temp($name);
                }


                //$key_exist_idxbuilding = array_search($value_item['codBuilding'], array_column($result_idxbuilding_wp, 'code'));

                $gallery_tg = '';

                $name = $value_item['name'];
                $address = $value_item['address'];
                $lat = $value_item['lat'];
                $lng = $value_item['lng'];
                $year = $value_item['year'];
                $floor = $value_item['floor'];
                $units = $value_item['unitBuilding'];
                $cod_buillding = $value_item['codBuilding'];
                $category = $value_item['type_building'];

                if (empty($floor)) {
                    $floor = '0';
                }

                $temp_id = base64_encode(random_bytes(10));

                if (!empty($value_item['gallery']) && is_array($value_item['gallery']) && count($value_item['gallery']) > 0) {
                    $gallery_tg = $value_item['gallery'][0]['url_image'];
                }

                //is new page

                $building_category = 'complete-building';

                if ($category == '1') {
                    $building_category = 'pre-construction';
                }


                if (!is_numeric($key_exist_tgbuilding)) {
                    $insert_pages_idxboost[] = "('" . addslashes($name) . "','tgbuilding','publish','" . $cod_buillding . "','" . generar_url_temp($name) . "')";
                    $response_data_new_items[] = array('name' => $name, 'address' => $address, 'lat' => $lat, 'lng' => $lng, 'year' => $year, 'unit' => $units, 'code' => $cod_buillding, 'gallery' => $gallery_tg, 'category' => $category, 'floor' => $floor, 'slug' => $path_building);
                } else {

                    $id_building = $result_tgbuilding_wp[$key_exist_tgbuilding]['ID'];
                    $exist_build_cat = array_search($id_building, $columns_category);
                    //COMPROBAMOS QUE SI YA TIENE REGISTRADO LA CATEGORIA EL BUILDING EN EL WORDPRESS

                    if ($exist_build_cat) {
                        //actualiza
                        $keys_category = array_search($building_category, $list_term_slug);
                        if (is_numeric($keys_category) && array_key_exists($keys_category, $categorys_loop)) {
                            $update_relationship_cate[] = " WHEN object_id = '" . $id_building . "' THEN '" . $categorys_loop[$keys_category]['term_id'] . "' ";
                        }
                    } else {
                        //crea nuevo
                        /*cateogry*/
                        $keys_category = array_search($building_category, $list_term_slug);
                        if (is_numeric($keys_category) && array_key_exists($keys_category, $categorys_loop)) {
                            $values_category[] = "('" . $id_building . "','" . $categorys_loop[$keys_category]['term_id'] . "','0')";
                        }
                    }


                    $list_building_id[] = $id_building;
                    $title_update[] = " WHEN ID = '" . $id_building . "' THEN '" . addslashes($name) . "' ";
                    $meta_update['dgt_extra_floor']['query'][] = " WHEN meta_key='dgt_extra_floor' and post_id = '" . $id_building . "' THEN '" . $floor . "' ";
                    $meta_update['tgbuilding_url']['query'][] = " WHEN meta_key='tgbuilding_url' and post_id = '" . $id_building . "' THEN '" . get_site_url() . '/' . $building_slug . '/' . $path_building . "' ";
                    $meta_update['dgt_extra_address']['query'][] = " WHEN meta_key='dgt_extra_address' and post_id = '" . $id_building . "' THEN '" . addslashes($address) . "' ";
                    //comentado por joseph cambios de latitud y longitud que vienen del cpanel
                    //$meta_update['dgt_extra_lat']['query'][]=" WHEN meta_key='dgt_extra_lat' and post_id = '".$id_building."' THEN '".addslashes($lat)."' ";
                    //$meta_update['dgt_extra_lng']['query'][]=" WHEN meta_key='dgt_extra_lng' and post_id = '".$id_building."' THEN '".addslashes($lng)."' ";
                    $meta_update['dgt_year_building']['query'][] = " WHEN meta_key='dgt_year_building' and post_id = '" . $id_building . "' THEN '" . addslashes($year) . "' ";
                    $meta_update['dgt_extra_unit']['query'][] = " WHEN meta_key='dgt_extra_unit' and post_id = '" . $id_building . "' THEN '" . addslashes($units) . "' ";
                    $meta_update['dgt_tg_idxboost_building']['query'][] = " WHEN meta_key='dgt_tg_idxboost_building' and post_id = '" . $id_building . "' THEN '" . $cod_buillding . "' ";
                    $meta_update['dgt_tg_gallery']['query'][] = " WHEN meta_key='dgt_tg_gallery' and post_id = '" . $id_building . "' THEN '" . addslashes($gallery_tg) . "' ";
                }
            }

            //actualizamos las antiguas listas
            if (!empty($insert_pages_idxboost) && is_array($insert_pages_idxboost) && count($insert_pages_idxboost) > 0) {
                $result_pages_insert = $wpdb->query($estruct_insert_page . implode(',', $insert_pages_idxboost));
            }

            $list_update_temp = [];
            $list_update_keys = [];

            if (!empty($meta_update) && is_array($meta_update) && count($meta_update) > 0) {
                foreach ($meta_update as $key_update => $value_update) {
                    if (count($value_update['query']) > 0) {
                        $list_update_temp[] = implode(' ', $value_update['query']) . ' ';
                        $list_update_keys[] = '"' . $key_update . '"';
                    }
                }

                if (count($list_update_temp) > 0) {
                    $query_update = $estruct_update_postmeta . implode(' ', $list_update_temp) . ' END WHERE post_id in(' . implode(',', $list_building_id) . ') and meta_key in (' . implode(',', $list_update_keys) . ');';
                    $wpdb->query($query_update);
                }
            }
            //fin de los items actualizados

            $list_title_temp = [];
            if (!empty($title_update) && is_array($title_update) && count($title_update) > 0) {
                $query_update_post = $estruct_update_wppost . implode(' ', $title_update) . ' END WHERE ID in(' . implode(',', $list_building_id) . ') ;';
                $wpdb->query($query_update_post);
            }

            if (!empty($update_relationship_cate) && is_array($update_relationship_cate) && count($update_relationship_cate) > 0) {
                $query_update_categories = $struct_update_relationship . implode(' ', $update_relationship_cate) . ' END WHERE object_id in(' . implode(',', $list_building_id) . ') ;';
                $wpdb->query($query_update_categories);
            }

            //inicio proceso guardar los nuevos items para sus metas
            if (!empty($response_data_new_items) && is_array($response_data_new_items) && count($response_data_new_items) > 0) {
                $list_codes = '"' . implode('","', array_map(function ($item) {
                        return $item['code'];
                    }, $response_data_new_items)) . '"';

                $result_tgbuilding_wp_new = $wpdb->get_results("SELECT post.ID,post.post_title as name,post.post_mime_type as code FROM wp_posts post where post_type='tgbuilding' and post.post_mime_type in (" . $list_codes . ");", ARRAY_A);
                $list_build_new = [];

                $list_term_slug = array_column($categorys_loop, 'slug');

                if (is_array($result_tgbuilding_wp_new) && count($result_tgbuilding_wp_new) > 0) {

                    $list_build_new = array_column($result_tgbuilding_wp_new, 'code');

                    foreach ($response_data_new_items as $key => $value_item) {
                        $key_exist_tgbuilding = array_search($value_item['code'], $list_build_new);

                        if (is_numeric($key_exist_tgbuilding)) {
                            $id_building = $result_tgbuilding_wp_new[$key_exist_tgbuilding]['ID'];

                            $meta_insert[] = "('" . $id_building . "','dgt_extra_floor','" . $value_item['floor'] . "')";
                            $meta_insert[] = "('" . $id_building . "','tgbuilding_url','" . get_site_url() . '/' . $building_slug . '/' . $value_item['slug'] . "')";
                            $meta_insert[] = "('" . $id_building . "','dgt_extra_address','" . $value_item['address'] . "')";
                            $meta_insert[] = "('" . $id_building . "','dgt_extra_lat','" . $value_item['lat'] . "')";
                            $meta_insert[] = "('" . $id_building . "','dgt_extra_lng','" . $value_item['lng'] . "')";
                            $meta_insert[] = "('" . $id_building . "','dgt_year_building','" . $value_item['year'] . "')";
                            $meta_insert[] = "('" . $id_building . "','dgt_extra_unit','" . $value_item['unit'] . "')";
                            $meta_insert[] = "('" . $id_building . "','dgt_tg_idxboost_building','" . $value_item['code'] . "')";
                            $meta_insert[] = "('" . $id_building . "','dgt_tg_gallery','" . $value_item['gallery'] . "')";


                            /*cateogry*/
                            $building_category_new = 'complete-building';
                            if ($value_item['category'] == '1') {
                                $building_category_new = 'pre-construction';
                            }
                            $keys_category_new = array_search($building_category_new, $list_term_slug);
                            if (is_numeric($keys_category_new) && array_key_exists($keys_category_new, $categorys_loop)) {
                                $values_category[] = "('" . $id_building . "','" . $categorys_loop[$keys_category_new]['term_id'] . "','0')";
                            }
                            //end category
                        }
                    }
                }
            }

            if (!empty($meta_insert) && is_array($meta_insert) && count($meta_insert) > 0) {
                $result_pages_insert_meta = $wpdb->query($wp_postmeta_insert . implode(',', $meta_insert));
            }

            if (!empty($values_category) && is_array($values_category) && count($values_category) > 0) {
                $query_insert_categories = $wpdb->query($struct_table_relationship . implode(',', $values_category));
            }
        }


        wp_send_json(['status' => true, 'message' => 'Upload susscess', 'category' => $values_category, 'update_post' => $query_update_post, 'category_query' => $struct_table_relationship . implode(',', $values_category), 'update' => $query_update, 'insert' => $meta_insert, 'new_insert' => $response_data_new_items, 'cate_update' => $update_relationship_cate, 'status_data' => $status_data, 'meta_update' => $meta_update]);
        exit;
    }
}

if (!function_exists('flex_idx_agents_admin_columns_head')) {
    function flex_idx_agents_admin_columns_head($defaults)
    {
        unset($defaults['date']);
        $defaults['agent_first_name'] = 'First Name';
        $defaults['agent_last_name'] = 'Last Name';
        $defaults['agent_phone'] = 'Phone Number';
        $defaults['agent_email'] = 'Email Address';
        $defaults['agent_registration_key'] = 'Registration Key';
        $defaults['date'] = 'Date';
        return $defaults;
    }

    add_filter('manage_idx-agents_posts_columns', 'flex_idx_agents_admin_columns_head', 10);
}

if (!function_exists('flex_idx_agents_admin_columns_content')) {
    function flex_idx_agents_admin_columns_content($column_name, $post_ID)
    {
        switch ($column_name) {
            case 'agent_first_name':
                $flex_agent_first_name = get_post_meta($post_ID, '_flex_agent_first_name', true);
                echo $flex_agent_first_name;
                break;

            case 'agent_last_name':
                $flex_agent_last_name = get_post_meta($post_ID, '_flex_agent_last_name', true);
                echo $flex_agent_last_name;
                break;

            case 'agent_phone':
                $flex_agent_phone = get_post_meta($post_ID, '_flex_agent_phone', true);
                echo $flex_agent_phone;
                break;

            case 'agent_email':
                $flex_agent_email = get_post_meta($post_ID, '_flex_agent_email', true);
                echo $flex_agent_email;
                break;

            case 'agent_registration_key':
                $flex_agent_registration_key = get_post_meta($post_ID, '_flex_agent_registration_key', true);
                echo $flex_agent_registration_key;
                break;
        }
    }

    add_action('manage_idx-agents_posts_custom_column', 'flex_idx_agents_admin_columns_content', 10, 2);
}

if (!function_exists('flex_filter_pages_admin_columns_head')) {
    function flex_filter_pages_admin_columns_head($defaults)
    {
        unset($defaults['date']);
        $defaults['filter_id'] = 'Filter ID';
        $defaults['filter_listing_type'] = 'Listing Type';
        $defaults['filter_featured'] = 'Featured';
        $defaults['date'] = 'Date';
        return $defaults;
    }

    add_filter('manage_flex-filter-pages_posts_columns', 'flex_filter_pages_admin_columns_head', 10);
}
if (!function_exists('flex_building_pages_admin_columns_head')) {
    function flex_building_pages_admin_columns_head($defaults)
    {
        unset($defaults['date']);
        $defaults['building_id'] = 'Building ID';
        $defaults['date'] = 'Date';
        return $defaults;
    }

    add_filter('manage_flex-idx-building_posts_columns', 'flex_building_pages_admin_columns_head', 10);
}
if (!function_exists('flex_off_market_listing_pages_admin_columns_head')) {
    function flex_off_market_listing_pages_admin_columns_head($defaults)
    {
        unset($defaults['date']);
        $defaults['Token_id'] = 'Token ID';
        $defaults['date'] = 'Date';
        return $defaults;
    }

    add_filter('manage_idx-off-market_posts_columns', 'flex_off_market_listing_pages_admin_columns_head', 10);
}
if (!function_exists('flex_filter_has_featured_page')) {
    function flex_filter_has_featured_page()
    {
        global $wpdb;
        $featured_listings_page_ID = $wpdb->get_var("
        SELECT t1.id
        FROM {$wpdb->posts} t1
        INNER JOIN {$wpdb->postmeta} t2
        ON t1.ID = t2.post_id
        WHERE t1.post_type = 'flex-filter-pages'
        AND t1.post_status = 'publish'
        AND t2.meta_key = '_flex_filter_page_show_home'
        AND t2.meta_value = 1
        LIMIT 1
        ");
        if (empty($featured_listings_page_ID)) {
            return null;
        }
        $filter_page_token_ID = (string)get_post_meta($featured_listings_page_ID, '_flex_filter_page_id', true);
        return $filter_page_token_ID;
    }
}
if (!function_exists('flex_filter_pages_admin_columns_content')) {
    function flex_filter_pages_admin_columns_content($column_name, $post_ID)
    {
        switch ($column_name) {
            case 'filter_id':
                $flex_filter_page_id = get_post_meta($post_ID, '_flex_filter_page_id', true);
                echo $flex_filter_page_id;
                break;
            case 'filter_listing_type':
                $flex_filter_page_fl = get_post_meta($post_ID, '_flex_filter_page_fl', true);
                switch ($flex_filter_page_fl) {
                    case 0:
                        echo 'Search Bar Hidden';
                        break;
                    case 1:
                        echo 'Recent Sales';
                        break;
                    case 2:
                        echo 'Exclusive Listings';
                        break;
                    case 3:
                        echo 'Search Bar Included';
                        break;
                }
                break;
            case 'filter_featured':
                $flex_filter_page_show_home = (int)get_post_meta($post_ID, '_flex_filter_page_show_home', true);
                if ($flex_filter_page_show_home === 1) {
                    echo 'YES';
                }
                break;
        }
    }

    add_action('manage_flex-filter-pages_posts_custom_column', 'flex_filter_pages_admin_columns_content', 10, 2);
}
if (!function_exists('flex_building_pages_admin_columns_content')) {
    function flex_building_pages_admin_columns_content($column_name, $post_ID)
    {
        switch ($column_name) {
            case 'building_id':
                $flex_building_page_id = get_post_meta($post_ID, '_flex_building_page_id', true);
                echo $flex_building_page_id;
                break;
        }
    }

    add_action('manage_flex-idx-building_posts_custom_column', 'flex_building_pages_admin_columns_content', 10, 2);
}
if (!function_exists('flex_offmarlket_pages_admin_columns_content')) {
    function flex_offmarlket_pages_admin_columns_content($column_name, $post_ID)
    {
        switch ($column_name) {
            case 'Token_id':
                $flex_building_page_id = get_post_meta($post_ID, '_flex_token_listing_page_id', true);
                echo $flex_building_page_id;
                break;
        }
    }

    add_action('manage_idx-off-market_posts_custom_column', 'flex_offmarlket_pages_admin_columns_content', 10, 2);
}
if (!function_exists('flex_http_request')) {
    function flex_http_request($uri, $params, $method = 'POST')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        curl_setopt($ch, CURLOPT_URL, $uri);
        $server_output = curl_exec($ch);
        $response = [];
        if ($server_output === false) {
            $response = [
                'error_code' => curl_errno($ch),
                'error_message' => htmlspecialchars(curl_error($ch)),
            ];
        } else {
            $response = json_decode($server_output, true);
        }
        curl_close($ch);
        return $response;
    }
}
if (!function_exists('flex_encode_keyword_string')) {
    function flex_encode_keyword_string($input)
    {
        return str_replace(array(' ', '#', '/', '&'), array('~', ':', '_', ';'), $input);
    }
}
if (!function_exists('flex_decode_keyword_string')) {
    function flex_decode_keyword_string($input)
    {
        return str_replace(array('~', ':', '_', ';'), array(' ', '#', '/', '&'), $input);
    }
}
if (!function_exists('flex_include_html_partial')) {
    function flex_include_html_partial()
    {
        ob_start();
        global $flex_idx_info;
        $has_smart_property_alerts = false;
        if (!empty($flex_idx_info['agent']['has_smart_property_alerts']) && $flex_idx_info['agent']['has_smart_property_alerts'] != false && $flex_idx_info['agent']['has_smart_property_alerts'] == 1) {
            $has_smart_property_alerts = true;
        }

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/form/modals.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/form/modals.php';
        } else {
            include FLEX_IDX_PATH . '/views/form/modals.php';
        }
        $output = ob_get_clean();
        echo $output;
    }

    add_action('wp_footer', 'flex_include_html_partial');
}
if (!function_exists('flex_json_decode')) {
    function is_flex_json_value($input)
    {
        if (!empty($input)) {
            json_decode($input);
            return (json_last_error() == JSON_ERROR_NONE);
        }
        return false;
    }
}
if (!function_exists('flex_phone_number_filter')) {
    function flex_phone_number_filter($input)
    {
        if (!empty($input)) {
            $input = preg_replace('/[^\d]+/', '', $input);
            return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $input);
        }
        return null;
    }
}
if (!function_exists('flex_map_array')) {
    function flex_map_array($rows)
    {
        $output = array();
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $key => $row) {
                $output[$row['key']] = is_flex_json_value($row['value']) ? json_decode($row['value'], true) : $row['value'];
            }
        }
        return $output;
    }
}
if (!function_exists('idxboost_array_sort_by_column')) {
    function idxboost_array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
    {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
        array_multisort($sort_col, $dir, $arr);
    }
}
if (!function_exists('flex_idx_get_info')) {
    function flex_idx_get_info()
    {
        global $wpdb;
        // fetch info
        $idxboost_commercial_types = get_option('idxboost_commercial_types');

        $idxboost_search_settings = get_option('idxboost_search_settings');
        $idxboost_pusher_settings = get_option('idxboost_pusher_settings');
        $idxboost_agent_info = get_option('idxboost_agent_info');
        $template_name = get_template_directory();
        $template_name = basename($template_name);
        $output = array();
        // basic info
        $output['website_name'] = get_bloginfo('name');
        $output['website_url'] = get_bloginfo('wpurl');
        $output['template_name'] = $template_name;
        $output['template_directory_url'] = get_template_directory_uri();
        $output['url_logo'] = get_option('flex_idx_alerts_url_logo');
        // pages info
        $output['pages'] = idxboost_list_pages();
        // agent info
        #$list_agent_info = $wpdb->get_results('SELECT `key`,`value` FROM flex_idx_settings WHERE `key` LIKE "agent_%"', ARRAY_A);
        #$output['agent'] = flex_map_array($list_agent_info);

        $output['agent']['has_dynamic_ads'] = isset($idxboost_agent_info['has_dynamic_ads']) ? (bool)$idxboost_agent_info['has_dynamic_ads'] : false;
        $output['agent']['has_seo_client'] = isset($idxboost_agent_info['has_seo_client']) ? (bool)$idxboost_agent_info['has_seo_client'] : false;

        $output['agent']['has_basic_idx'] = isset($idxboost_agent_info['has_basic_idx']) ? (bool)$idxboost_agent_info['has_basic_idx'] : false;
        $output['agent']['has_building'] = isset($idxboost_agent_info['has_building']) ? (bool)$idxboost_agent_info['has_building'] : false;
        $output['agent']['has_boost_box_ads'] = isset($idxboost_agent_info['has_boost_box_ads']) ? (bool)$idxboost_agent_info['has_boost_box_ads'] : false;

        $output['agent']['hackbox'] = isset($idxboost_agent_info['hackbox']) ? $idxboost_agent_info['hackbox'] : '';
        $output['agent']['agent_first_name'] = isset($idxboost_agent_info['first_name']) ? $idxboost_agent_info['first_name'] : '';
        $output['agent']['agent_last_name'] = isset($idxboost_agent_info['last_name']) ? $idxboost_agent_info['last_name'] : '';
        $output['agent']['agent_email_address'] = isset($idxboost_agent_info['email_address']) ? $idxboost_agent_info['email_address'] : '';
        $output['agent']['agent_phone_number'] = isset($idxboost_agent_info['phone_number']) ? $idxboost_agent_info['phone_number'] : '';
        $output['agent']['agent_address'] = isset($idxboost_agent_info['address']) ? $idxboost_agent_info['address'] : '';
        $output['agent']['agent_address2'] = isset($idxboost_agent_info['address2']) ? $idxboost_agent_info['address2'] : '';
        $output['agent']['agent_city'] = isset($idxboost_agent_info['city']) ? $idxboost_agent_info['city'] : '';
        $output['agent']['agent_state'] = isset($idxboost_agent_info['state']) ? $idxboost_agent_info['state'] : '';
        $output['agent']['agent_zip_code'] = isset($idxboost_agent_info['zip_code']) ? $idxboost_agent_info['zip_code'] : '';
        $output['agent']['agent_website_url'] = isset($idxboost_agent_info['website_url']) ? $idxboost_agent_info['website_url'] : '';
        $output['agent']['agent_contact_first_name'] = isset($idxboost_agent_info['contact_first_name']) ? $idxboost_agent_info['contact_first_name'] : '';
        $output['agent']['agent_contact_last_name'] = isset($idxboost_agent_info['contact_last_name']) ? $idxboost_agent_info['contact_last_name'] : '';
        $output['agent']['agent_contact_email_address'] = isset($idxboost_agent_info['contact_email_address']) ? $idxboost_agent_info['contact_email_address'] : '';
        $output['agent']['agent_contact_phone_number'] = isset($idxboost_agent_info['contact_phone_number']) ? $idxboost_agent_info['contact_phone_number'] : '';
        $output['agent']['agent_contact_photo_profile'] = isset($idxboost_agent_info['contact_photo_profile']) ? $idxboost_agent_info['contact_photo_profile'] : '';
        $output['agent']['has_cms'] = isset($idxboost_agent_info['has_cms']) ? $idxboost_agent_info['has_cms'] : '';
        $output['agent']['has_smart_property_alerts'] = isset($idxboost_agent_info['has_smart_property_alerts']) ? $idxboost_agent_info['has_smart_property_alerts'] : '';
        $output['agent']['has_cms_form'] = isset($idxboost_agent_info['has_cms_form']) ? $idxboost_agent_info['has_cms_form'] : '';
        $output['agent']['has_cms_team'] = isset($idxboost_agent_info['has_cms_team']) ? $idxboost_agent_info['has_cms_team'] : '';
        $output['agent']['track_gender'] = isset($idxboost_agent_info['track_gender']) ? $idxboost_agent_info['track_gender'] : "";
        $output['agent']['agent_logo_file'] = isset($idxboost_agent_info['agent_logo_file']) ? $idxboost_agent_info['agent_logo_file'] : '';
        $output['agent']['broker_logo_file'] = isset($idxboost_agent_info['broker_logo_file']) ? $idxboost_agent_info['broker_logo_file'] : '';
        $output['agent']['agent_address_lat'] = isset($idxboost_agent_info['address_lat']) ? $idxboost_agent_info['address_lat'] : '';
        $output['agent']['agent_address_lng'] = isset($idxboost_agent_info['address_lng']) ? $idxboost_agent_info['address_lng'] : '';
        $output['agent']['force_registration'] = isset($idxboost_agent_info['force_registration']) ? (int)$idxboost_agent_info['force_registration'] : 0;
        $output['agent']['user_show_quizz'] = isset($idxboost_agent_info['user_show_quizz']) ? (int)$idxboost_agent_info['user_show_quizz'] : 0;
        $output['agent']['facebook_app_id'] = isset($idxboost_agent_info['facebook_app_id']) ? $idxboost_agent_info['facebook_app_id'] : "";
        $output['agent']['track_gender'] = isset($idxboost_agent_info['track_gender']) ? $idxboost_agent_info['track_gender'] : "";
        $output['agent']['google_client_id'] = isset($idxboost_agent_info['google_client_id']) ? $idxboost_agent_info['google_client_id'] : "";
        $output['agent']['google_client_id'] = isset($idxboost_agent_info['google_client_id']) ? $idxboost_agent_info['google_client_id'] : "";
        $output['agent']['facebook_login_enabled'] = isset($idxboost_agent_info['facebook_login_enabled']) ? $idxboost_agent_info['facebook_login_enabled'] : false;
        $output['agent']['google_login_enabled'] = isset($idxboost_agent_info['google_login_enabled']) ? $idxboost_agent_info['google_login_enabled'] : false;
        $output['agent']['google_maps_api_key'] = isset($idxboost_agent_info['google_maps_api_key']) ? $idxboost_agent_info['google_maps_api_key'] : "";
        $output['agent']['google_captcha_public_key'] = isset($idxboost_agent_info['google_captcha_public_key']) ? (string)$idxboost_agent_info['google_captcha_public_key'] : "";
        //$output['agent']['google_captcha_private_key'] = isset($idxboost_agent_info['google_captcha_private_key']) ? (string) $idxboost_agent_info['google_captcha_private_key'] : "";
        $output['agent']['google_analytics'] = isset($idxboost_agent_info['google_analytics']) ? $idxboost_agent_info['google_analytics'] : "";
        $output['agent']['google_adwords'] = isset($idxboost_agent_info['google_adwords']) ? $idxboost_agent_info['google_adwords'] : "";
        $output['agent']['facebook_pixel'] = isset($idxboost_agent_info['facebook_pixel']) ? $idxboost_agent_info['facebook_pixel'] : "";
        $output['agent']['google_gtm'] = isset($idxboost_agent_info['google_gtm']) ? $idxboost_agent_info['google_gtm'] : "";
        $output['agent']['stat_counter_security_id'] = isset($idxboost_agent_info['stat_counter_security_id']) ? $idxboost_agent_info['stat_counter_security_id'] : "";
        $output['agent']['stat_counter_project_id'] = isset($idxboost_agent_info['stat_counter_project_id']) ? $idxboost_agent_info['stat_counter_project_id'] : "";
        $output['agent']['follow_up_boss_api_key'] = isset($idxboost_agent_info['follow_up_boss_api_key']) ? $idxboost_agent_info['follow_up_boss_api_key'] : "";
        $output['agent']['follow_up_boss_source'] = isset($idxboost_agent_info['follow_up_boss_source']) ? $idxboost_agent_info['follow_up_boss_source'] : "";
        $output['agent']['signup_left_clicks'] = isset($idxboost_agent_info['signup_left_clicks']) ? $idxboost_agent_info['signup_left_clicks'] : null;
        $output['agent']['force_registration_forced'] = isset($idxboost_agent_info['force_registration_forced']) ? (bool)$idxboost_agent_info['force_registration_forced'] : false;

        $output['agent']['has_enterprise_recaptcha'] = isset($idxboost_agent_info['has_enterprise_recaptcha']) ? (bool)$idxboost_agent_info['has_enterprise_recaptcha'] : false;
        $output['agent']['recaptcha_site_key'] = isset($idxboost_agent_info['recaptcha_site_key']) ? $idxboost_agent_info['recaptcha_site_key'] : null;
        $output['agent']['recaptcha_api_key'] = isset($idxboost_agent_info['recaptcha_api_key']) ? $idxboost_agent_info['recaptcha_api_key'] : null;

        // social info
        #$list_social_info = $wpdb->get_results('SELECT `key`,`value` FROM flex_idx_settings WHERE `key` LIKE "%_social_url"', ARRAY_A);
        #$output['social'] = flex_map_array($list_social_info);
        $output['social']['facebook_social_url'] = $idxboost_agent_info['facebook_social_url'];
        $output['social']['twitter_social_url'] = $idxboost_agent_info['twitter_social_url'];
        $output['social']['gplus_social_url'] = $idxboost_agent_info['gplus_social_url'];
        $output['social']['youtube_social_url'] = $idxboost_agent_info['youtube_social_url'];
        $output['social']['instagram_social_url'] = $idxboost_agent_info['instagram_social_url'];
        $output['social']['linkedin_social_url'] = $idxboost_agent_info['linkedin_social_url'];
        $output['social']['pinterest_social_url'] = $idxboost_agent_info['pinterest_social_url'];
        // search info $idxboost_search_settings
        $output['board_id'] = isset($idxboost_search_settings['board_id']) ? $idxboost_search_settings['board_id'] : null;
        $output['board_info'] = isset($idxboost_search_settings['board_info']) ? $idxboost_search_settings['board_info'] : null;
        $output['search']['amenities'] = $idxboost_search_settings['amenities'];
        $output['search']['baths_range'] = $idxboost_search_settings['baths_range'];
        $output['search']['beds_range'] = $idxboost_search_settings['beds_range'];
        $output['search']['cities'] = $idxboost_search_settings['cities'];
        $output['search']['default_sort'] = $idxboost_search_settings['default_sort'];
        $output['search']['default_view'] = $idxboost_search_settings['default_view'];
        $output['search']['living_size_range'] = $idxboost_search_settings['living_size_range'];
        $output['search']['lot_size_range'] = $idxboost_search_settings['lot_size_range'];
        $output['search']['parking_options'] = $idxboost_search_settings['parking_options'];
        $output['search']['price_rent_range'] = $idxboost_search_settings['price_rent_range'];
        $output['search']['price_sale_range'] = $idxboost_search_settings['price_sale_range'];
        $output['search']['property_types'] = $idxboost_search_settings['property_types'];
        $output['search']['rental_types'] = $idxboost_search_settings['default_rental_type'];
        $output['search']['view_grid_type'] = $idxboost_search_settings['default_view_grid'];
        $output['search']['view_icon_type'] = $idxboost_search_settings['default_view_icon'];
        $output['search']['schools_ratio'] = $idxboost_search_settings['default_schools_ratio'];
        $output['search']['waterfront_options'] = $idxboost_search_settings['waterfront_options'];
        $output['search']['year_built_range'] = $idxboost_search_settings['year_built_range'];
        $output['search']['default_language'] = $idxboost_search_settings['default_language'];
        $output['search']['default_floor_plan'] = $idxboost_search_settings['default_floor_plan'];
        $output['search']['idx_listings_type'] = (int)$idxboost_search_settings['idx_listings_type'];
        /*$list_search_info = $wpdb->get_results('SELECT `key`,`value` FROM flex_idx_settings WHERE `key` LIKE "search_%"', ARRAY_A);
        $output['search'] = flex_map_array($list_search_info);
        if (!empty($output['search']) && isset($output['search']['search_idx_cities']) ) {
            idxboost_array_sort_by_column($output['search']['search_idx_cities'], 'name');
        }*/
        // pusher info
        #$list_pusher_info = $wpdb->get_results('SELECT `key`,`value` FROM flex_idx_settings WHERE `key` LIKE "pusher_%"', ARRAY_A);
        #$output['pusher'] = flex_map_array($list_pusher_info);
        $output['pusher']['pusher_app_key'] = $idxboost_pusher_settings['app_key'];
        $output['pusher']['pusher_app_cluster'] = $idxboost_pusher_settings['app_cluster'];
        $output['pusher']['pusher_presence_channel'] = $idxboost_pusher_settings['presence_channel'];

        $output['commercial_types'] = $idxboost_commercial_types;

        return $output;
    }
}
if (!function_exists('idxboost_list_pages')) {
    function idxboost_list_pages()
    {
        global $wpdb;
        $idxboost_pages = array();
        $list_pages = $wpdb->get_results("
        select ID, post_title, post_name, guid, t2.meta_value AS page_id
        from {$wpdb->posts} t1
        inner join {$wpdb->postmeta} t2
        on t1.ID = t2.post_id
        where t1.post_type = 'flex-idx-pages'
        and t1.post_status = 'publish'
        and t2.meta_key = '_flex_id_page'
        ", ARRAY_A);
        foreach ($list_pages as $idxboost_page) {
            $idxboost_page['guid'] = implode('/', array(site_url(), $idxboost_page['post_name']));
            $idxboost_pages[$idxboost_page["page_id"]] = $idxboost_page;
        }
        return $idxboost_pages;
    }
}
if (!function_exists('flex_user_list_pages')) {
    function flex_user_list_pages()
    {
        global $wpdb, $flex_idx_info;
        $list_pages = array();
        foreach ($flex_idx_info["pages"] as $page_id => $page_info) {
            if (preg_match("/^my-(.*)/", $page_info["post_name"])) {
                $list_pages[] = array(
                    "post_title" => $page_info["post_title"],
                    "permalink" => $page_info["guid"]
                );
            }
        }
        return $list_pages;
    }
}
if (!function_exists('idxboost_autologin_alerts_fn')) {
    function idxboost_autologin_alerts_fn()
    {
        $client_ip = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';

        global $wpdb, $wp, $flex_idx_info;
        if (!empty($_GET)) {
            if (is_array($_GET)) {
                if (array_key_exists('token_authau', $_GET)) {
                    $access_token = flex_idx_get_access_token();
                    $event_auto_login = '';
                    if (array_key_exists('event', $_GET)) {
                        $event_auto_login = $_GET['event'];
                    }

                    $sendParams = array('access_token' => $access_token, 'alert_token' => $_GET['token_authau'], 'event_login' => $event_auto_login);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_TRACK_PROPERTY_LOOK_TOKEN);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                    $server_output = curl_exec($ch);
                    $dataTokentem = json_decode($server_output, true);
                    curl_close($ch);
                    if (is_array($_COOKIE)) {
                        if (array_key_exists('ib_lead_token', $_COOKIE) == false) {
                            if (is_array($dataTokentem)) {

                                if (array_key_exists('lead_info', $dataTokentem)) {
                                    if (!empty($dataTokentem['lead_info'])) {
                                        $idx_info_lead = $dataTokentem['lead_info'];
                                    }
                                }

                                if (array_key_exists('encode_token', $dataTokentem)) {
                                    if (!empty($dataTokentem['encode_token'])) {
                                        $encode_token = $dataTokentem['encode_token'];
                                    }
                                }

                                if (!empty($idx_info_lead) || !empty($encode_token)) {
                                    //listing view

                                    //get mls_num
                                    $wp_request = $wp->request;
                                    $wp_request_exp = explode('/', $wp_request);

                                    list($page, $slug) = $wp_request_exp;

                                    if (strstr($slug, '-rx-')) {
                                        $exp_slug = explode('-', $slug);
                                        $mls_num = 'rx-' . end($exp_slug);
                                    } else {
                                        $exp_slug = explode('-', $slug);
                                        $mls_num = end($exp_slug);
                                    }
                                    //get mls_num

                                    if (!empty($mls_num)) {
                                        $params_listing_view = [
                                            "access_token" => $access_token,
                                            "lead_token" => $encode_token,
                                            "client_ip" => $client_ip,
                                            "url_referer" => $referer,
                                            "url_origin" => $origin,
                                            "user_agent" => $agent,
                                            "mls_number" => $mls_num,
                                            "board_id" => $flex_idx_info['board_id']
                                        ];

                                        $ch_listing_view = curl_init();
                                        curl_setopt($ch_listing_view, CURLOPT_URL, FLEX_IDX_API_TRACK_PROPERTY_VIEW);
                                        curl_setopt($ch_listing_view, CURLOPT_POST, 1);
                                        curl_setopt($ch_listing_view, CURLOPT_POSTFIELDS, http_build_query($params_listing_view));
                                        curl_setopt($ch_listing_view, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($ch_listing_view, CURLOPT_REFERER, ib_get_http_referer());
                                        $output_listing_view = curl_exec($ch_listing_view);
                                        curl_close($ch_listing_view);
                                        $response_listing_view = json_decode($output_listing_view, true);
                                    }

                                    //listing view
                                    ?>
                                    <script type="text/javascript">
                                        <?php if (!empty($idx_info_lead)) { ?>
                                        var idx_info_lead = <?php echo json_encode($idx_info_lead); ?>;

                                        (function ($) {
                                            //INICITIAL VARIABLES USER
                                            $("#_ib_fn_inq").val(idx_info_lead.first_name);
                                            $("#_ib_ln_inq").val(idx_info_lead.last_name);
                                            $("#_ib_em_inq").val(idx_info_lead.email_address);
                                            $("#_ib_ph_inq").val(idx_info_lead.phone_number);

                                            $("._ib_fn_inq").val(idx_info_lead.first_name);
                                            $("._ib_ln_inq").val(idx_info_lead.last_name);
                                            $("._ib_em_inq").val(idx_info_lead.email_address);
                                            $("._ib_ph_inq").val(idx_info_lead.phone_number);

                                            //Building default label
                                            var ob_form_building_footer;
                                            ob_form_building_footer = $('.flex_idx_building_form');

                                            if (ob_form_building_footer.length > 0) {
                                                ob_form_building_footer.find('[name="first_name"]').val(idx_info_lead.first_name);
                                                ob_form_building_footer.find('[name="last_name"]').val(idx_info_lead.last_name);
                                                ob_form_building_footer.find('[name="email"]').val(idx_info_lead.phone_number);
                                                ob_form_building_footer.find('[name="phone"]').val(idx_info_lead.email_address);
                                            }

                                            //modal regular filter default label
                                            var ob_form_modal;
                                            ob_form_modal = $('.ib-propery-inquiry-f');
                                            if (ob_form_modal.length > 0) {
                                                ob_form_modal.find('[name="first_name"]').val(idx_info_lead.first_name);
                                                ob_form_modal.find('[name="last_name"]').val(idx_info_lead.last_name);
                                                ob_form_modal.find('[name="email_address"]').val(idx_info_lead.phone_number);
                                                ob_form_modal.find('[name="phone_number"]').val(idx_info_lead.email_address);
                                            }

                                            //Off market listing default label
                                            var ob_form_off_market_listing;
                                            ob_form_off_market_listing = $('#flex-idx-property-form');
                                            if (ob_form_off_market_listing.length > 0) {
                                                ob_form_off_market_listing.find('[name="first_name"]').val(idx_info_lead.first_name);
                                                ob_form_off_market_listing.find('[name="last_name"]').val(idx_info_lead.last_name);
                                                ob_form_off_market_listing.find('[name="email"]').val(idx_info_lead.phone_number);
                                                ob_form_off_market_listing.find('[name="phone"]').val(idx_info_lead.email_address);
                                            }
                                            //INICITIAL VARIABLES USER

                                            var htmlMenuidx = [];

                                            htmlMenuidx.push('<li class="login show_modal_login_active">');
                                            htmlMenuidx.push('<a href="javascript:void(0)" rel="nofollow">' + word_translate.welcome + ' ' + idx_info_lead.first_name + '</a>');
                                            htmlMenuidx.push('<div class="menu_login_active">');
                                            htmlMenuidx.push('<ul>');
                                            htmlMenuidx.push('<li><a href="' + __flex_g_settings.page_setting.flex_idx_favorites.guid + '">' + __flex_g_settings.page_setting.flex_idx_favorites.post_title + '</a></li>');
                                            htmlMenuidx.push('<li><a href="' + __flex_g_settings.page_setting.flex_idx_saved_searches.guid + '">' + __flex_g_settings.page_setting.flex_idx_saved_searches.post_title + '</a></li>');
                                            htmlMenuidx.push('<li><a href="' + __flex_g_settings.page_setting.flex_idx_profile.guid + '">' + __flex_g_settings.page_setting.flex_idx_profile.post_title + '</a></li>');
                                            htmlMenuidx.push('<li><a href="#" class="flex-logout-link" id="flex-logout-link" rel="nofollow">' + word_translate.logout + '</a></li>');
                                            htmlMenuidx.push('</ul>');
                                            htmlMenuidx.push('</div>');
                                            htmlMenuidx.push('</li>');


                                            $("#user-options").html(htmlMenuidx.join(''));

                                            __flex_g_settings.anonymous = "no";

                                        })(jQuery);

                                        <?php } ?>

                                        <?php if (!empty($encode_token)) { ?>
                                        Cookies.set('ib_lead_token', "<?php echo $encode_token; ?>", {
                                            expires: 30
                                        });
                                        <?php
                                        $_COOKIE['ib_lead_token'] = $encode_token;
                                        } ?>
                                    </script>
                                    <?php
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
if (!function_exists('flex_idx_posttype_pages_fn')) {
    function flex_idx_posttype_pages_fn()
    {
        global $wpdb;

        $result_building_slug = $wpdb->get_results("
      SELECT t1.post_name,t2.meta_value as idx_filter
      FROM {$wpdb->posts} t1
      inner join {$wpdb->postmeta} t2
      on t1.ID = t2.post_id
      where t1.post_type = 'flex-idx-pages' 
      and 
        ( t1.post_status = 'publish' and t2.meta_key = '_flex_id_page' and t2.meta_value = 'flex_idx_building' ) or
        (t1.post_status = 'publish' and t2.meta_key = '_flex_id_page' and t2.meta_value = 'flex_idx_sub_area' ) or 
        (t1.post_status = 'publish' and t2.meta_key = '_flex_id_page' and t2.meta_value = 'flex_idx_off_market_listing' )
        
      limit 2
      ", ARRAY_A);

        //var_dump($building_slug);
        $building_slug = 'building';
        $sub_area_slug = 'sub-area';
        $off_market_listing_slug = 'off-market-listing';
        $keys_building = array_search('flex_idx_building', array_column($result_building_slug, 'idx_filter'));

        if (is_numeric($keys_building)) {
            $building_slug = $result_building_slug[$keys_building]['post_name'];
        }

        $keys_sub_area = array_search('flex_idx_sub_area', array_column($result_building_slug, 'idx_filter'));
        if (is_numeric($keys_sub_area)) {
            $sub_area_slug = $result_building_slug[$keys_sub_area]['post_name'];
        }

        $keys_off_market_listing = array_search('flex_idx_off_market_listing', array_column($result_building_slug, 'idx_filter'));
        if (is_numeric($keys_off_market_listing)) {
            $off_market_listing_slug = $result_building_slug[$keys_off_market_listing]['post_name'];
        }

        register_post_type('flex-idx-building', array(
            'public' => true,
            'exclude_from_search' => true,
            'show_in_menu' => false,
            'label' => 'My Buildings',
            'rewrite' => array(
                'with_front' => false,
                'slug' => $building_slug,
            ),
            'supports' => array('title', 'page-attributes', 'post-formats'),
            'capability_type' => 'post'
        ));
        register_post_type('flex-idx-pages', array(
            'public' => true,
            'exclude_from_search' => true,
            'show_in_menu' => false,
            'label' => 'Page’s URL Slug',
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'flex-idx-pages'
            ),
            'supports' => array('title', 'editor', 'page-attributes'),
            'capability_type' => 'post'
        ));
        register_post_type('flex-landing-pages', array(
            'public' => true,
            'exclude_from_search' => true,
            'show_in_menu' => false,
            'label' => 'Map Search Filters',
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'flex-landing-pages'
            ),
            'hierarchical' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'capability_type' => 'post',
        ));
        register_post_type('idx-off-market', array(
            'public' => true,
            'exclude_from_search' => true,
            'show_in_menu' => false,
            'label' => 'Off Market Inventory',
            'rewrite' => array(
                'with_front' => false,
                'slug' => $off_market_listing_slug,
            ),
            'supports' => array('title', 'page-attributes', 'post-formats'),
            'capability_type' => 'post'
        ));
        register_post_type('flex-filter-pages', array(
            'public' => true,
            'exclude_from_search' => true,
            'show_in_menu' => false,
            'label' => 'Display Filters',
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'flex-filter-pages'
            ),
            'supports' => array('title', 'editor', 'thumbnail'),
            'capability_type' => 'post',
        ));


        register_post_type('idx-sub-area', array(
            'public' => true,
            'exclude_from_search' => true,
            'show_in_menu' => false,
            'label' => 'My Master Plans',
            'rewrite' => array(
                'with_front' => false,
                'slug' => $sub_area_slug,
            ),
            'supports' => array('title', 'page-attributes', 'post-formats'),
            'capability_type' => 'post'
        ));

        register_post_type('idx-agents', array(
            'public' => true,
            'exclude_from_search' => true,
            'show_in_menu' => false,
            'label' => 'Agents',
            'rewrite' => array(
                'with_front' => false,
                'slug' => 'idx-agents',
            ),
            'supports' => array('title', 'editor', 'thumbnail'),
            'capability_type' => 'post'
        ));

        // setup rewrite rules
        flex_idx_rewrite_rules();
        flush_rewrite_rules();
    }
}
if (!function_exists('flex_idx_rewrite_rules')) {
    function flex_idx_rewrite_rules()
    {
        global $wpdb;

        // handle search $permalink
        /*
      $search_slug = $wpdb->get_var("
      select t1.post_name
      from {$wpdb->posts} t1
      inner join {$wpdb->postmeta} t2
      on t1.ID = t2.post_id
      where t1.post_type = 'flex-idx-pages'
      and t1.post_status = 'publish'
      and t2.meta_key = '_flex_id_page'
      and t2.meta_value = 'flex_idx_search'
      limit 1
      ");
      if (!empty($search_slug)) {
        add_rewrite_rule(sprintf('^%s/?$', $search_slug), sprintf('index.php?flex-idx-pages=%s', $search_slug), 'top');
        add_rewrite_rule(sprintf('^%s/(.*)?', $search_slug), sprintf('index.php?flex-idx-pages=%s', $search_slug), 'top');
      }
      */
        // handle property detail permalink
        $property_slug = $wpdb->get_var("
      select t1.post_name
      from {$wpdb->posts} t1
      inner join {$wpdb->postmeta} t2
      on t1.ID = t2.post_id
      where t1.post_type = 'flex-idx-pages'
      and t1.post_status = 'publish'
      and t2.meta_key = '_flex_id_page'
      and t2.meta_value = 'flex_idx_property_detail'
      limit 1
      ");
        if (!empty($property_slug)) {
            add_rewrite_rule(sprintf('^%s/([^/]+)/?$', $property_slug), sprintf('index.php?flex-idx-pages=%s', $property_slug), 'top');
        }

        // handle active agent pages
        $active_agent_pages = $wpdb->get_results("
      select post_name
      from {$wpdb->posts}
      where post_type = 'idx-agents'
      and post_status = 'publish'
      ", ARRAY_A);

        if (!empty($active_agent_pages)) {
            foreach ($active_agent_pages as $rewrite_agent_page) {
                add_rewrite_rule(sprintf('^%s/([^/]+)/?$', $rewrite_agent_page['post_name']), sprintf('index.php?idx-agents=%s', $rewrite_agent_page['post_name']), 'top');
            }
        }
    }
}
if (!function_exists('flex_idx_on_activation')) {
    function flex_idx_on_activation()
    {
        // define custom post types
        flex_idx_posttype_pages_fn();
        // flush rewrite rules
        flush_rewrite_rules();
        // setup IDX Boost pages
        flex_idx_setup_pages_fn();
    }
}
if (!function_exists('flex_idx_on_deactivation')) {
    function flex_idx_on_deactivation()
    {
        flush_rewrite_rules();
    }
}
if (!function_exists('flex_idx_on_uninstall')) {
    function flex_idx_on_uninstall()
    {
        flush_rewrite_rules();
    }
}
if (!function_exists('is_flex_user_logged_in')) {
    function is_flex_user_logged_in()
    {
        // check credentials api
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEADS_CHECK_CREDENTIALS);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);
        if ((is_array($response) && isset($response['success'])) && true === $response['success']) {
            return $response;
        }
        return false;
    }
}
if (!function_exists('flex_lead_signup_xhr_fn')) {
    function flex_lead_signup_xhr_fn()
    {
        $access_token = flex_idx_get_access_token();
        $response = [];
        $email = isset($_POST['register_email']) ? trim(strip_tags($_POST['register_email'])) : '';
        $ib_tags = isset($_POST['ib_tags']) ? trim(strip_tags($_POST['ib_tags'])) : '';
        $name = isset($_POST['register_name']) ? trim(strip_tags($_POST['register_name'])) : '';
        $lastName = isset($_POST['register_last_name']) ? trim(strip_tags($_POST['register_last_name'])) : '';
        $phone = isset($_POST['register_phone']) ? trim(strip_tags($_POST['register_phone'])) : '';
        $password = isset($_POST['register_password']) ? trim(strip_tags($_POST['register_password'])) : '';
        $logon_type = isset($_POST['logon_type']) ? trim(strip_tags($_POST['logon_type'])) : '';
        $timeline_for_purchase = isset($_POST['timeline_for_purchase']) ? trim(strip_tags($_POST['timeline_for_purchase'])) : '';
        $mortgage_approved = isset($_POST['mortgage_approved']) ? trim(strip_tags($_POST['mortgage_approved'])) : '';
        $sell_a_home = isset($_POST['sell_a_home']) ? trim(strip_tags($_POST['sell_a_home'])) : '';
        $ip_address = get_client_ip_server();
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $url_origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $window_width = isset($_POST["window_width"]) ? (int)$_POST["window_width"] : 0;
        $signup_price = isset($_POST["__property_signup_price"]) ? (int)$_POST["__property_signup_price"] : 0;

        $source_registration_title = isset($_POST['source_registration_title']) ? trim($_POST['source_registration_title']) : '';
        $source_registration_url = isset($_POST['source_registration_url']) ? trim($_POST['source_registration_url']) : '';

        $sendParams = array(
            'access_token' => $access_token,
            'email' => $email,
            'name' => $name,
            'lastName' => $lastName,
            'phone' => $phone,
            'password' => $password,
            'logon_type' => $logon_type,
            'timeline_for_purchase' => $timeline_for_purchase,
            'mortgage_approved' => $mortgage_approved,
            'sell_a_home' => $sell_a_home,
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
            'url_origin' => $url_origin,
            'ib_tags' => $ib_tags,
            'signup_price' => $signup_price,
            'source_registration_title' => $source_registration_title,
            'source_registration_url' => $source_registration_url
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEADS_SIGNUP);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        $flex_idx_lead = is_flex_user_logged_in();
        $my_flex_pages = flex_user_list_pages();
        ob_start();
        // if ($window_width < 640) {
        ?>
        <li class="login show_modal_login_active">
            <a href="javascript:void(0)" rel="nofollow">
                <?php echo __('Welcome', IDXBOOST_DOMAIN_THEME_LANG); ?><?php echo $name; ?>
            </a>
            <div class="menu_login_active">
                <?php if (!empty($my_flex_pages)) : ?>
                    <ul>
                        <?php foreach ($my_flex_pages as $my_flex_page) : ?>
                            <li>
                                <a href="<?php echo $my_flex_page['permalink']; ?>"><?php echo $my_flex_page['post_title']; ?></a>
                            </li>
                        <?php endforeach; ?>
                        <li>
                            <a href="#" class="flex-logout-link" id="flex-logout-link" rel="nofollow">
                                <?php echo __('Logout', IDXBOOST_DOMAIN_THEME_LANG); ?>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </li>
        <?php
        // }
        $response_html = ob_get_clean();
        $response["output"] = $response_html;
        $response["last_logged_in_username"] = $email;
        wp_send_json($response);
        exit;
    }
}
/*PASSWORD*/
if (!function_exists('flex_idx_get_resetpass_xhr_fn')) {
    function flex_idx_get_resetpass_xhr_fn()
    {
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $reset_email = isset($_POST['reset_email']) ? sanitize_text_field($_POST['reset_email']) : '';
        $tokepa = isset($_POST['tokepa']) ? trim($_POST['tokepa']) : '';
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'reset_email' => $reset_email,
            'token' => $tokepa
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEADS_GET_RESET_PASSWORD);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_lead_resetpass_xhr_fn')) {
    function flex_idx_lead_resetpass_xhr_fn()
    {
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $reset_email = isset($_POST['reset_email']) ? sanitize_text_field($_POST['reset_email']) : '';
        $password = isset($_POST['user_pass']) ? trim($_POST['user_pass']) : '';
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'reset_email' => $reset_email,
            'password' => $password
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEADS_RESET_PASSWORD);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
/*PASSWORD*/
if (!function_exists('idxboost_save_filter_search_alert_xhr_fn')) {
    function idxboost_save_filter_search_alert_xhr_fn()
    {
        $access_token = flex_idx_get_access_token();
        //search_filter
    }
}

if (!function_exists('flex_lead_signin_xhr_fn')) {
    function flex_lead_signin_xhr_fn()
    {
        $access_token = flex_idx_get_access_token();
        $username = isset($_POST['user_name']) ? sanitize_text_field($_POST['user_name']) : '';
        $password = isset($_POST['user_pass']) ? trim($_POST['user_pass']) : '';
        $logon_type = isset($_POST['logon_type']) ? trim($_POST['logon_type']) : '';
        $user_info = isset($_POST['user_info']) ? $_POST['user_info'] : null;
        $ip_address = get_client_ip_server();
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $url_origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $window_width = isset($_POST["window_width"]) ? (int)$_POST["window_width"] : 0;
        $signup_price = isset($_POST["__property_signup_price"]) ? (int)$_POST["__property_signup_price"] : 0;

        $source_registration_title = isset($_POST['source_registration_title']) ? trim($_POST['source_registration_title']) : '';
        $source_registration_url = isset($_POST['source_registration_url']) ? trim($_POST['source_registration_url']) : '';
        $ib_tags = isset($_POST["ib_tags"]) ? trim(strip_tags($_POST["ib_tags"])) : "";

        $sendParams = array(
            'access_token' => $access_token,
            'logon_type' => $logon_type,
            'email' => $username,
            'password' => $password,
            'user_info' => $user_info,
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
            'url_origin' => $url_origin,
            'signup_price' => $signup_price,
            'source_registration_title' => $source_registration_title,
            'source_registration_url' => $source_registration_url,
            "ib_tags" => $ib_tags
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEADS_LOGIN);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        $flex_idx_lead = is_flex_user_logged_in();
        $my_flex_pages = flex_user_list_pages();
        ob_start();
        if (!isset($response["first_name"])) {
            $response["first_name"] = isset($user_info["first_name"]) ? strip_tags($user_info["first_name"]) : "";
        }

        // if ($window_width < 640) {
        ?>
        <li class="login show_modal_login_active">
            <a href="javascript:void(0)"
               rel="nofollow"><?php echo __('Welcome', IDXBOOST_DOMAIN_THEME_LANG); ?><?php echo $response["first_name"]; ?></a>
            <div class="menu_login_active">
                <?php if (!empty($my_flex_pages)) : ?>
                    <ul>
                        <?php foreach ($my_flex_pages as $my_flex_page) : ?>
                            <li>
                                <a href="<?php echo $my_flex_page['permalink']; ?>"><?php echo $my_flex_page['post_title']; ?></a>
                            </li>
                        <?php endforeach; ?>
                        <li><a href="#" class="flex-logout-link" id="flex-logout-link"
                               rel="nofollow"><?php echo __('Logout', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </li>
        <?php
        // }

        $response_html = ob_get_clean();

        $response["output"] = $response_html;

        $response["last_logged_in_username"] = $username;
        if (empty($response["last_logged_in_username"])) {
            $response["last_logged_in_username"] = (!empty($user_info) && isset($user_info["email"])) ? $user_info["email"] : "";
        }
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('get_flex_idx_search_settings')) {
    function get_flex_idx_search_settings()
    {
        global $wpdb;
        $search_settings = $wpdb->get_results('SELECT `key`,`value` FROM flex_idx_settings WHERE `key` LIKE "search_%"');
        $output_settings = array();
        foreach ($search_settings as $settings) {
            $output_settings[$settings['key']] = $settings['value'];
        }
        return $output_settings;
    }
}

if (!function_exists('ib_add_missing_scheme')) {
    function ib_add_missing_scheme($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            if (isset($_SERVER["HTTPS"])) {
                $has_https_on = true;
            } else {
                $has_https_on = false;
            }

            if ($has_https_on) {
                $url = "https://" . $url;
            } else {
                $url = "http://" . $url;
            }
        }

        return $url;
    }
}

if (!function_exists("ib_get_http_referer")) {
    function ib_get_http_referer()
    {
        if (isset($_SERVER["HTTP_HOST"])) {
            return ib_add_missing_scheme($_SERVER["HTTP_HOST"]);
        }

        if (isset($_SERVER["HTTP_REFERER"])) {
            return ib_add_missing_scheme($_SERVER["HTTP_REFERER"]);
        }

        if (isset($_SERVER["SERVER_NAME"])) {
            return ib_add_missing_scheme($_SERVER["SERVER_NAME"]);
        }

        return "";
    }
}

if (!function_exists("flex_idx_generate_access_token")) {
    function flex_idx_generate_access_token()
    {
        $registration_key = get_option('idxboost_registration_key');

        $send_params = array(
            'registration_key' => $registration_key
        );

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => FLEX_IDX_API_GENERATE_NEW_TOKEN,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_REFERER => ib_get_http_referer(),
            CURLOPT_POSTFIELDS => http_build_query($send_params)
        ));

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        // set_transient('flex_api_access_token', $response['access_token'], 3500);

        return $response['access_token'];
    }
}

if (!function_exists('flex_idx_get_access_token')) {
    function flex_idx_get_access_token()
    {
        global $flex_idx_token;

        return $flex_idx_token;

        // global $wpdb;
        // $access_token = get_transient('flex_api_access_token');
        // if (false === get_transient('flex_api_access_token')) {
        //     $registration_key = get_option('idxboost_registration_key');
        //     $send_params = array(
        //         'registration_key' => $registration_key
        //     );
        //     $ch = curl_init();
        //     curl_setopt_array($ch, array(
        //         CURLOPT_URL => FLEX_IDX_API_VERIFY_CREDENTIALS,
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 30,
        //         CURLOPT_CUSTOMREQUEST => "POST",
        //         CURLOPT_POSTFIELDS => http_build_query($send_params)
        //     ));
        //     $server_output = curl_exec($ch);
        //     curl_close($ch);
        //     $response = json_decode($server_output, true);
        //     if (is_array($response) && isset($response['access_token'])) {
        //         $access_token = $response['access_token'];
        //         update_option('idxboost_registration_key', $registration_key);
        //         set_transient('flex_api_access_token', $access_token, 3500);
        //         update_option('idxboost_client_status', 'active');
        //     } else {
        //         update_option('idxboost_client_status', 'inactive');
        //         delete_transient('flex_api_access_token');
        //     }
        // }
        // return $access_token;
    }
}
function flex_is_valid_url($url)
{
    $_domain_regex = "|^[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,})/?$|";
    if (preg_match($_domain_regex, $url)) {
        return true;
    }
    $_regex = '#^([a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))$#';
    if (preg_match($_regex, $url, $matches)) {
        $_parts = parse_url($url);
        if (!in_array($_parts['scheme'], array('http', 'https')))
            return false;
        if (!preg_match($_domain_regex, $_parts['host']))
            return false;
        return true;
    }
    return false;
}

if (!function_exists('flex_connect_launch_fn')) {
    function flex_connect_launch_fn()
    {
        global $wpdb;
        $access_token = flex_idx_get_access_token();
        $response = [];
        $sendParams = [];
        $current_user_id = get_current_user_id();
        $api_registration_launch = isset($_POST['flex_idx_registration_launch']) ? sanitize_text_field($_POST['flex_idx_registration_launch']) : '';
        $flex_idx_registration_launch = get_option('flex_idx_registration_launch');
        if ($flex_idx_registration_launch == false) {
            if (flex_is_valid_url($api_registration_launch)) {
                update_option('flex_idx_registration_launch', $api_registration_launch);
                $response['launch_key'] = $flex_idx_registration_launch;
                $response['message'] = $api_registration_launch . "is a valid URL";
                $response['success'] = true;
                $sendParams = array('WebsiteClient' => $api_registration_launch, 'access_token' => $access_token);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_BASE_TICKET);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($server_output, true);
            } else {
                $response['message'] = $api_registration_launch . "is not a valid URL";
                $response['success'] = false;
            }
        } else {
            $response['message'] = "Problem, you already generated a launch.";
            $response['success'] = false;
        }
        wp_send_json($response);
    }
}
if (!function_exists('flex_idx_import_data_fn')) {
    function flex_idx_import_data_fn()
    {
        global $wpdb, $flex_idx_info;
        $idxboost_registration_key = get_option('idxboost_registration_key');
        $current_user_id = get_current_user_id();
        $response = [];
        if (false == get_option('idxboost_import_initial_data')) {
            $sendParams = array(
                'registration_key' => $idxboost_registration_key
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_IMPORT_DATA);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
            $server_output = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($server_output, true);
            if (!empty($response['agent_info'])) { // idxboost_agent_info
                $agent_info = $response['agent_info'];
                update_option('idxboost_agent_info', $agent_info);
                // update theme mod options
                $theme_options = get_option('theme_mods_' . $flex_idx_info['template_name']);
                $build_array = array();
                if (empty($agent_info['broker_logo_file'])) {
                    $build_array['idx_image_logo_footer'] = $agent_info['broker_website_url']; // left bottom (agent logo)
                    $build_array['idx_theme_custom']['idx_image_logo_mobile_theme'] = $agent_info['broker_website_url'];
                } else {
                    $build_array['idx_image_logo_footer'] = $agent_info['broker_logo_file']; // left bottom (agent logo)
                    $build_array['idx_theme_custom']['idx_image_logo_mobile_theme'] = $agent_info['broker_logo_file'];
                }
                $build_array['idx_plugin_custom']['idx_text_search_bar'] = 'Your Real Estate Resource'; // Your Real Estate Resource
                if (empty($agent_info['agent_logo_file'])) {
                    $build_array['idx_site_text'] = $agent_info['agent_logo_text'];
                    $build_array['idx_site_text_slogan'] = $agent_info['agent_logo_headline'];
                    update_option('idx_site_radio_sta', 'text');
                } else {
                    $build_array['idx_image_logo'] = $agent_info['agent_logo_file']; // top left (agent logo)
                    $build_array['idx_site_text_slogan'] = 'Real Estate Website';
                    update_option('idx_site_radio_sta', 'image');
                }
                $build_array['idx_txt_description_front'] = $agent_info['welcome_text']; // lorem...
                $build_array['idx_txt_title_front'] = 'Welcome to my Website'; // Welcome to my website
                $build_array['idx_social_media']['facebook'] = $agent_info['facebook_social_url'];
                $build_array['idx_social_media']['twitter'] = $agent_info['twitter_social_url'];
                $build_array['idx_social_media']['google'] = $agent_info['gplus_social_url'];
                $build_array['idx_social_media']['instagram'] = $agent_info['instagram_social_url'];
                $build_array['idx_social_media']['linkedin'] = $agent_info['linkedin_social_url'];
                $build_array['idx_social_media']['youtube'] = $agent_info['youtube_social_url'];
                $build_array['idx_social_media']['google_maps'] = $agent_info['google_maps_api_key'];
                $build_array['idx_site_text'] = $agent_info['website_title'];
                $build_array['idx_txt_text_property_front'] = 'VIEW MORE PROPERTIES';
                $build_array['idx_txt_text_tit_property_front'] = 'FEATURED PROPERTIES';
                $build_array['idx_txt_text_welcome_front'] = 'ABOUT US';
                $aboutPageID = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_title = 'About' AND post_type = 'page' and post_status = 'publish' limit 1");
                $build_array['idx_txt_link_welcome_front'] = get_permalink($aboutPageID);
                $build_array['idx_languages_list'] = array(
                    'English' => '1',
                    'Russian' => '1',
                    'Spanish' => '1',
                    'Portuguese' => '1',
                    'German' => '1',
                    'Chinese' => '1'
                );
                $build_array['idx_txt_text_welcome_about_first'] = 'View our recent sales';
                $build_array['idx_txt_text_welcome_about_second'] = 'View my exclusive listings';
                $recentSalesPageID = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_title = 'Recent Sales' AND post_type = 'flex-filter-pages' and post_status = 'publish' limit 1");
                $build_array['idx_txt_link_welcome_about_firts'] = get_permalink($recentSalesPageID);
                $exclusiveListingsPageID = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_title = 'Exclusive Listings' AND post_type = 'flex-filter-pages' and post_status = 'publish' limit 1");
                $build_array['idx_txt_link_welcome_about_second'] = get_permalink($exclusiveListingsPageID);
                $theme_options = array_merge($theme_options, $build_array);
                update_option('theme_mods_' . $flex_idx_info['template_name'], $theme_options);
                // update about page
                $bio_text = apply_filters('the_content', $agent_info['bio']);
                if (!empty($bio_text)) {
                    $wpdb->query(sprintf("UPDATE {$wpdb->posts} SET post_content = '%s' WHERE post_title = 'About' AND post_type = 'page' AND post_status = 'publish' LIMIT 1", esc_sql($bio_text)));
                }
                if (!empty($agent_info['contact_photo_profile'])) {
                    $aboutPageID = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_title = 'About' AND post_type = 'page' AND post_status = 'publish' LIMIT 1");
                    idxboost_attach_image_to_post($agent_info['contact_photo_profile'], $aboutPageID);
                }
            }
            if (!empty($response['pusher_settings'])) { // idxboost_pusher_settings
                $pusher_info = $response['pusher_settings'];
                update_option('idxboost_pusher_settings', $pusher_info);
            }
            if (!empty($response['search_settings'])) { // idxboost_search_settings
                $search_settings = $response['search_settings'];
                update_option('idxboost_search_settings', $search_settings);
            }
            if (!empty($response['commercial_types'])) { // idxboost_search_settings
                $idxboost_commercial_types = $response['commercial_types'];
                update_option('idxboost_commercial_types', $idxboost_commercial_types);
            }

            if (isset($response['filter_pages']) && is_array($response['filter_pages'])) {
                $wp_agent_filters = $wpdb->get_col("
                SELECT t2.meta_value
                FROM {$wpdb->posts} t1
                INNER JOIN {$wpdb->postmeta} t2
                ON t1.ID = t2.post_id
                WHERE t1.post_type = 'flex-filter-pages' AND t1.post_status = 'publish'
                AND t2.meta_key = '_flex_filter_page_id'
                ");
                foreach ($response['filter_pages'] as $filter_page) {
                    if (in_array($filter_page['filter_id'], $wp_agent_filters)) {
                        continue;
                    }
                    $wp_filter_page = wp_insert_post(array(
                        'post_title' => $filter_page['title'],
                        'post_name' => sanitize_title($filter_page['title']),
                        'post_content' => $filter_page['description'],
                        'post_status' => 'publish',
                        'post_author' => $current_user_id,
                        'post_type' => 'flex-filter-pages'
                    ));
                    if (!empty($filter_page['thumbnail'])) {
                        idxboost_attach_image_to_post($filter_page['thumbnail'], $wp_filter_page);
                    }
                    update_post_meta($wp_filter_page, '_flex_filter_page_id', $filter_page['filter_id']);
                    update_post_meta($wp_filter_page, '_flex_filter_page_fl', $filter_page['listing_type']);
                    if (isset($filter_page['is_featured']) && (true === $filter_page['is_featured'])) {
                        update_post_meta($wp_filter_page, '_flex_filter_page_show_home', '1');
                    }
                    update_post_meta($wp_filter_page, '_flex_imported_filter_page', 'yes');
                }
            }
            if (isset($response['building_pages']) && is_array($response['building_pages'])) {
                $wp_agent_buildings = $wpdb->get_col("
              SELECT t2.meta_value
              FROM {$wpdb->posts} t1
              INNER JOIN {$wpdb->postmeta} t2
              ON t1.ID = t2.post_id
              WHERE t1.post_type = 'flex-idx-building' AND t1.post_status = 'publish'
              AND t2.meta_key = '_flex_building_page_id'
              ");
                foreach ($response['building_pages'] as $building_page) {
                    if (in_array($my_building['building_id'], $wp_agent_buildings)) {
                        continue;
                    }
                    $wp_building_page = wp_insert_post(array(
                        'post_title' => $building_page['title'],
                        'post_name' => sanitize_title($building_page['title']),
                        'post_content' => '',
                        'post_status' => 'publish',
                        'post_author' => $current_user_id,
                        'post_type' => 'flex-idx-building'
                    ));
                    update_post_meta($wp_building_page, '_flex_building_page_id', $building_page['building_id']);
                    update_post_meta($wp_building_page, '_flex_imported_page', 'yes');
                }
            }
            if ($response['agent_info']['template_id'] == 'fortune') {

                if (isset($response['building_group_pages']) && is_array($response['building_group_pages'])) {
                    $wp_agent_building_group_pages = $wpdb->get_col("
                  SELECT t1.post_title
                  FROM {$wpdb->posts} t1
                  INNER JOIN {$wpdb->postmeta} t2
                  ON t1.ID = t2.post_id
                  WHERE t1.post_type = 'page' AND t1.post_status = 'publish'
                  AND t2.meta_key = '_flex_imported_building_group_page'
                  ");
                    foreach ($response['building_group_pages'] as $building_group_page) {
                        if (in_array($building_group_page['title'] . ' Buildings', $wp_agent_building_group_pages)) {
                            continue;
                        }
                        $wp_building_group_page = wp_insert_post(array(
                            'post_title' => $building_group_page['title'] . ' Buildings',
                            'post_name' => sanitize_title($building_group_page['title'] . ' Buildings'),
                            'post_content' => $building_group_page['description'],
                            'post_status' => 'publish',
                            'post_author' => $current_user_id,
                            'post_type' => 'page'
                        ));
                        update_post_meta($wp_building_group_page, '_flex_imported_building_group_page', 'yes');
                    }
                }
            }

            if (isset($response['building_group_pages']) && is_array($response['building_group_pages'])) {
                $wp_agent_building_group_pages = $wpdb->get_col("
              SELECT t1.post_title
              FROM {$wpdb->posts} t1
              INNER JOIN {$wpdb->postmeta} t2
              ON t1.ID = t2.post_id
              WHERE t1.post_type = 'page' AND t1.post_status = 'publish'
              AND t2.meta_key = '_flex_imported_building_group_page'
              ");
                foreach ($response['building_group_pages'] as $building_group_page) {
                    if (in_array($building_group_page['title'] . ' Buildings', $wp_agent_building_group_pages)) {
                        continue;
                    }
                    $wp_building_group_page = wp_insert_post(array(
                        'post_title' => $building_group_page['title'] . ' Buildings',
                        'post_name' => sanitize_title($building_group_page['title'] . ' Buildings'),
                        'post_content' => $building_group_page['description'],
                        'post_status' => 'publish',
                        'post_author' => $current_user_id,
                        'post_type' => 'page'
                    ));
                    update_post_meta($wp_building_group_page, '_flex_imported_building_group_page', 'yes');
                }
            }
            // build menu
            $menu_name = 'Primary Menu';
            $menu_exists = wp_get_nav_menu_object($menu_name);
            if ($menu_exists) {
                wp_delete_nav_menu($menu_name);
            }
            $menu_id = wp_create_nav_menu($menu_name);
            $myPageID = $wpdb->get_var("SELECT * FROM {$wpdb->posts} WHERE post_title = 'Home' AND post_type = 'page' AND post_status = 'publish' LIMIT 1");
            $itemData = array(
                'menu-item-object-id' => $myPageID,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            );
            wp_update_nav_menu_item($menu_id, 0, $itemData);
            $aboutUsParentID = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'About Us',
                'menu-item-url' => '#',
                'menu-item-status' => 'publish'
            ));
            $agent_info_tbl = get_option('idxboost_agent_info');
            $myPageID = $wpdb->get_var("SELECT * FROM {$wpdb->posts} WHERE post_title = 'About' AND post_type = 'page' AND post_status = 'publish' LIMIT 1");
            $itemData = array(
                'menu-item-title' => 'Meet ' . $agent_info_tbl['first_name'] . ' ' . $agent_info_tbl['last_name'],
                'menu-item-object-id' => $myPageID,
                'menu-item-parent-id' => $aboutUsParentID,
                'menu-item-position' => 1,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            );
            wp_update_nav_menu_item($menu_id, 0, $itemData);
            $myPageID = $wpdb->get_var("SELECT * FROM {$wpdb->posts} WHERE post_title = 'Recent Sales' AND post_type = 'flex-filter-pages' AND post_status = 'publish' LIMIT 1");
            $itemData = array(
                'menu-item-object-id' => $myPageID,
                'menu-item-parent-id' => $aboutUsParentID,
                'menu-item-position' => 2,
                'menu-item-object' => 'flex-filter-pages',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            );
            wp_update_nav_menu_item($menu_id, 0, $itemData);
            $myPageID = $wpdb->get_var("SELECT * FROM {$wpdb->posts} WHERE post_title = 'Advanced Search Form' AND post_type = 'flex-idx-pages' AND post_status = 'publish' LIMIT 1");
            $itemData = array(
                'menu-item-title' => 'Search Properties',
                'menu-item-object-id' => $myPageID,
                'menu-item-object' => 'flex-idx-pages',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            );
            wp_update_nav_menu_item($menu_id, 0, $itemData);
            $myPageID = $wpdb->get_var("SELECT * FROM {$wpdb->posts} WHERE post_title = 'Exclusive Listings' AND post_type = 'flex-filter-pages' AND post_status = 'publish' LIMIT 1");
            $itemData = array(
                'menu-item-object-id' => $myPageID,
                'menu-item-object' => 'flex-filter-pages',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            );
            wp_update_nav_menu_item($menu_id, 0, $itemData);
            $neighborhoodsParentID = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'Neighborhoods',
                'menu-item-url' => '#',
                'menu-item-status' => 'publish'
            ));
            $fetch_neighborhoods = $wpdb->get_results("
                select t1.ID, t1.post_title, t1.post_type
                from {$wpdb->posts} t1
                inner join {$wpdb->postmeta} t2
                on t1.ID = t2.post_id
                where t1.post_type = 'flex-filter-pages'
                and t1.post_status = 'publish'
                and t2.meta_key = '_flex_imported_filter_page'
                and t2.meta_value = 'yes'
                and t1.post_title not in ('Exclusive Listings','Recent Sales')
                order by t1.post_title
                ", ARRAY_A);
            if (!empty($fetch_neighborhoods)) {
                foreach ($fetch_neighborhoods as $neighborhood) {
                    $itemData = array(
                        'menu-item-object-id' => $neighborhood['ID'],
                        'menu-item-parent-id' => $neighborhoodsParentID,
                        'menu-item-object' => $neighborhood['post_type'],
                        'menu-item-type' => 'post_type',
                        'menu-item-status' => 'publish'
                    );
                    wp_update_nav_menu_item($menu_id, 0, $itemData);
                }
            }
            $condoBuildingsParentID = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'Condo Buildings',
                'menu-item-url' => '#',
                'menu-item-status' => 'publish'
            ));
            $fetch_building_groups = $wpdb->get_results("
                select t1.ID, t1.post_title, t1.post_type
                from {$wpdb->posts} t1
                inner join {$wpdb->postmeta} t2
                on t1.ID = t2.post_id
                where t1.post_type = 'page'
                and t1.post_status = 'publish'
                and t2.meta_key = '_flex_imported_building_group_page'
                and t2.meta_value = 'yes'
                order by t1.post_title
                ", ARRAY_A);
            if (!empty($fetch_building_groups)) {
                foreach ($fetch_building_groups as $building_group) {
                    $itemData = array(
                        'menu-item-object-id' => $building_group['ID'],
                        'menu-item-parent-id' => $condoBuildingsParentID,
                        'menu-item-object' => $building_group['post_type'],
                        'menu-item-type' => 'post_type',
                        'menu-item-status' => 'publish'
                    );
                    wp_update_nav_menu_item($menu_id, 0, $itemData);
                }
            }
            $myPageID = $wpdb->get_var("SELECT * FROM {$wpdb->posts} WHERE post_title = 'Blog' AND post_type = 'page' AND post_status = 'publish' LIMIT 1");
            $itemData = array(
                'menu-item-object-id' => $myPageID,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            );
            wp_update_nav_menu_item($menu_id, 0, $itemData);
            $myPageID = $wpdb->get_var("SELECT * FROM {$wpdb->posts} WHERE post_title = 'Contact' AND post_type = 'page' AND post_status = 'publish' LIMIT 1");
            $itemData = array(
                'menu-item-object-id' => $myPageID,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            );
            wp_update_nav_menu_item($menu_id, 0, $itemData);
            add_option('idxboost_import_initial_data', 'yes');
        }
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('idx_save_tools_admin_form_fn')) {
    function idx_save_tools_admin_form_fn()
    {
        $response = [];
        $data_setting = ['status' => false];
        global $wpdb, $flex_idx_info;
        $data_parameters = [];
        if ($_POST && is_array($_POST)) {
            $data_parameters['idx_environment_site'] = $_POST['idx_environment_site'];
            $data_parameters['idx_map_style'] = $_POST['idx_map_style'];
            $response = fc_idx_save_tools_admin($data_parameters);
        }

        wp_send_json($response);

        exit();
    }
}


if (!function_exists('fc_idx_save_tools_admin')) {
    function fc_idx_save_tools_admin($parameters)
    {
        $response = [];
        $data_setting = ['status' => false];
        global $wpdb, $flex_idx_info;

        //setting for environment
        $path_feed = FLEX_IDX_PATH . 'feed/';
        $idx_environment_site = $parameters['idx_environment_site'];

        if (!empty($idx_environment_site)) {
            $data_setting['status'] = true;
            $data_setting['environment'] = $idx_environment_site;
            $file_setting_cache = json_encode($data_setting, true);
        }

        $idx_boost_setting = $path_feed . 'idx_boost_setting.json';
        $result_setting = file_put_contents($idx_boost_setting, $file_setting_cache);
        //setting for environment

        $response['success'] = false;
        $tbl_idxboost_tools = $wpdb->prefix . 'idxboost_setting';
        $idx_map_style = '';

        $wp_idxboost_tools = $wpdb->get_col("SELECT id FROM {$tbl_idxboost_tools}; ");


        if (array_key_exists('idx_map_style', $parameters) && !empty($parameters['idx_map_style'])) {
            $idx_map_style = $parameters['idx_map_style'];
        }

        if (is_array($wp_idxboost_tools) && count($wp_idxboost_tools) == 0) {
            $result_query = $wpdb->query("INSERT INTO {$tbl_idxboost_tools} (idx_map_style) VALUES('{$idx_map_style}'); ");
        } else {
            $result_query = $wpdb->query("UPDATE {$tbl_idxboost_tools} SET idx_map_style='{$idx_map_style}'; ");
        }
        $response['success'] = false;
        $response['message'] = 'Your register were saved !!';

        return $response;
    }
}


if (!function_exists('flex_idx_connect_fn')) {
    function flex_idx_connect_fn($return_json = false)
    {
        global $wpdb, $flex_idx_info;
        $current_user_id = get_current_user_id();

        if ($current_user_id == 0) {
            $current_user_id = 1;
        }
        $api_registration_key = isset($_POST['idxboost_registration_key']) ? sanitize_text_field($_POST['idxboost_registration_key']) : '';
        $sendParams = array(
            'registration_key' => $api_registration_key,
            'urlpoints' => get_site_url()
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_VERIFY_CREDENTIALS);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        if (isset($response['active_agents']) && is_array($response['active_agents'])) {
            $wp_agents = $wpdb->get_results("
            SELECT t2.meta_value,t1.ID
            FROM {$wpdb->posts} t1
            INNER JOIN {$wpdb->postmeta} t2
            ON t1.ID = t2.post_id
            WHERE t1.post_type = 'idx-agents' AND t1.post_status = 'publish'
            AND t2.meta_key = '_flex_agent_id'
            ", ARRAY_A);

            foreach ($response['active_agents'] as $idx_agent) {
                $GLOBALS["cod_agent"] = $idx_agent["id"];
                $exit_agent = array_values(
                    array_filter($wp_agents, function ($agent) {
                        return ($agent['meta_value'] == $GLOBALS["cod_agent"]);
                    })
                );

                if (is_array($exit_agent) && count($exit_agent) > 0) {
                    $id_agent_post = $exit_agent[0]["ID"];
                    $wp_idx_agent = wp_update_post(array(
                        'ID' => $id_agent_post,
                        'post_title' => implode(' ', array($idx_agent['contact_first_name'], $idx_agent['contact_last_name'])),
                        'post_name' => $idx_agent['agent_slug'],
                        'post_content' => $idx_agent['bio'],
                        'post_status' => 'publish',
                        'post_author' => $current_user_id,
                        'post_type' => 'idx-agents'
                    ));

                    if (!empty($idx_agent['agent_photo_file'])) {
                        idxboost_attach_image_to_post($idx_agent['agent_photo_file'], $wp_idx_agent);
                    }

                    update_post_meta($wp_idx_agent, '_flex_agent_id', $idx_agent['id']);
                    update_post_meta($wp_idx_agent, '_flex_agent_slug', $idx_agent['agent_slug']);
                    update_post_meta($wp_idx_agent, '_flex_agent_first_name', $idx_agent['contact_first_name']);
                    update_post_meta($wp_idx_agent, '_flex_agent_last_name', $idx_agent['contact_last_name']);
                    update_post_meta($wp_idx_agent, '_flex_agent_phone', $idx_agent['contact_phone']);
                    update_post_meta($wp_idx_agent, '_flex_agent_email', $idx_agent['contact_email']);
                    update_post_meta($wp_idx_agent, '_flex_agent_registration_key', $idx_agent['registration_key']);
                } else {
                    /*
                    if (in_array($idx_agent['id'], $wp_agents)) {
                        continue;
                    }
                    */
                    /*
                    $user_id = wp_create_user( $idx_agent['contact_email'], $idx_agent['contact_first_name'], $idx_agent['contact_email'] );
                    $user = new WP_User($user_id);
                    $user->set_role('editor');
                    wp_update_user([
                        'ID' => $user_id,
                        'first_name' => $idx_agent['contact_first_name'],
                        'last_name' => $idx_agent['contact_last_name'],
                    ]);
                    */

                    $wp_idx_agent = wp_insert_post(array(
                        'post_title' => implode(' ', array($idx_agent['contact_first_name'], $idx_agent['contact_last_name'])),
                        'post_name' => $idx_agent['agent_slug'],
                        'post_content' => $idx_agent['bio'],
                        'post_status' => 'publish',
                        'post_author' => $current_user_id,
                        'post_type' => 'idx-agents'
                    ));

                    if (!empty($idx_agent['agent_photo_file'])) {
                        idxboost_attach_image_to_post($idx_agent['agent_photo_file'], $wp_idx_agent);
                    }

                    update_post_meta($wp_idx_agent, '_flex_agent_id', $idx_agent['id']);
                    update_post_meta($wp_idx_agent, '_flex_agent_slug', $idx_agent['agent_slug']);
                    update_post_meta($wp_idx_agent, '_flex_agent_first_name', $idx_agent['contact_first_name']);
                    update_post_meta($wp_idx_agent, '_flex_agent_last_name', $idx_agent['contact_last_name']);
                    update_post_meta($wp_idx_agent, '_flex_agent_phone', $idx_agent['contact_phone']);
                    update_post_meta($wp_idx_agent, '_flex_agent_email', $idx_agent['contact_email']);
                    update_post_meta($wp_idx_agent, '_flex_agent_registration_key', $idx_agent['registration_key']);
                }
            }
        }

        if (isset($response['success']) && $response['success'] === true) {
            // update filters
            $wp_agent_filters = $wpdb->get_col("
            SELECT t2.meta_value
            FROM {$wpdb->posts} t1
            INNER JOIN {$wpdb->postmeta} t2
            ON t1.ID = t2.post_id
            WHERE t1.post_type = 'flex-filter-pages' AND t1.post_status = 'publish'
            AND t2.meta_key = '_flex_filter_page_id'
            ");
            foreach ($response['agent_filters'] as $my_filter) {
                if (in_array($my_filter['code'], $wp_agent_filters)) {
                    continue;
                }
                $wp_insert_filter = wp_insert_post(array(
                    'post_title' => $my_filter['name'],
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => $current_user_id,
                    'post_type' => 'flex-filter-pages'
                ));
                update_post_meta($wp_insert_filter, '_flex_filter_page_id', $my_filter['code']);
                update_post_meta($wp_insert_filter, '_flex_filter_page_fl', 3);
            }

            // update filters
            $wp_agent_search_filter_codes = $wpdb->get_col("
            SELECT t2.meta_value
            FROM {$wpdb->posts} t1
            INNER JOIN {$wpdb->postmeta} t2
            ON t1.ID = t2.post_id
            WHERE t1.post_type = 'flex-landing-pages' AND t1.post_status = 'publish'
            AND t2.meta_key = '_flex_filter_page_id'
            ");

            /*
            $wp_agent_search_filters = $wpdb->get_col("
            SELECT post_content
            FROM {$wpdb->posts}
            WHERE post_type = 'flex-landing-pages' AND post_status = 'publish'
            ");

            $wp_agent_search_filter_codes = [];

            foreach ($wp_agent_search_filters as $prev_my_search_filter) {
                preg_match("/(?:(?:\"(?:\\\\\"|[^\"])+\")|(?:'(?:\\\'|[^'])+'))/is", $prev_my_search_filter, $matches_sfilter);

                if (is_array($matches_sfilter) && isset($matches_sfilter[0])) {
                    $wp_agent_search_filter_codes[] = preg_replace("/[^a-zA-Z0-9]+/", "", $matches_sfilter[0]);
                }
            }
            */

            foreach ($response['agent_search_filters'] as $my_search_filter) {
                if (in_array($my_search_filter['code'], $wp_agent_search_filter_codes)) {
                    continue;
                }

                if (isset($my_search_filter["is_commercial"])) {
                    $is_commercial = (bool)$my_search_filter["is_commercial"];

                    if (true === $is_commercial) {
                        $wp_insert_filter = wp_insert_post(array(
                            'post_title' => $my_search_filter['name'],
                            'post_content' => sprintf('[ib_search_filter id="%s" is_commercial="1"]', $my_search_filter["code"]),
                            'post_status' => 'publish',
                            'post_author' => $current_user_id,
                            'post_type' => 'flex-landing-pages'
                        ));
                    } else {
                        $wp_insert_filter = wp_insert_post(array(
                            'post_title' => $my_search_filter['name'],
                            'post_content' => sprintf('[ib_search_filter id="%s" is_commercial="0"]', $my_search_filter["code"]),
                            'post_status' => 'publish',
                            'post_author' => $current_user_id,
                            'post_type' => 'flex-landing-pages'
                        ));
                    }
                } else {
                    $wp_insert_filter = wp_insert_post(array(
                        'post_title' => $my_search_filter['name'],
                        'post_content' => sprintf('[ib_search_filter id="%s" is_commercial="0"]', $my_search_filter["code"]),
                        'post_status' => 'publish',
                        'post_author' => $current_user_id,
                        'post_type' => 'flex-landing-pages'
                    ));
                }

                update_post_meta($wp_insert_filter, '_flex_filter_page_id', $my_search_filter['code']);
            }

            // $wp_agent_search_filters = $wpdb->get_col("
            // SELECT post_title
            // FROM {$wpdb->posts}
            // WHERE post_type = 'flex-landing-pages' AND post_status = 'publish'
            // ");

            // foreach($response['agent_search_filters'] as $my_search_filter) {
            //     if (in_array($my_search_filter['name'], $wp_agent_search_filters)) {
            //         continue;
            //     }

            //     if (isset($my_search_filter["is_commercial"])) {
            //         $is_commercial = (boolean) $my_search_filter["is_commercial"];

            //         if (true === $is_commercial) {
            //             $wp_insert_filter =  wp_insert_post(array(
            //                 'post_title'   => $my_search_filter['name'],
            //                 'post_content' => sprintf('[ib_search_filter id="%s" is_commercial="1"]', $my_search_filter["code"]),
            //                 'post_status'  => 'publish',
            //                 'post_author'  => $current_user_id,
            //                 'post_type'    => 'flex-landing-pages'
            //             ));
            //         } else {
            //             $wp_insert_filter =  wp_insert_post(array(
            //                 'post_title'   => $my_search_filter['name'],
            //                 'post_content' => sprintf('[ib_search_filter id="%s" is_commercial="0"]', $my_search_filter["code"]),
            //                 'post_status'  => 'publish',
            //                 'post_author'  => $current_user_id,
            //                 'post_type'    => 'flex-landing-pages'
            //             ));
            //         }
            //     } else {
            //         $wp_insert_filter =  wp_insert_post(array(
            //             'post_title'   => $my_search_filter['name'],
            //             'post_content' => sprintf('[ib_search_filter id="%s" is_commercial="0"]', $my_search_filter["code"]),
            //             'post_status'  => 'publish',
            //             'post_author'  => $current_user_id,
            //             'post_type'    => 'flex-landing-pages'
            //         ));
            //     }
            // }

            // off market listings
            $wp_off_market_listings = $wpdb->get_col("
            SELECT t2.meta_value
            FROM {$wpdb->posts} t1
            INNER JOIN {$wpdb->postmeta} t2
            ON t1.ID = t2.post_id
            WHERE t1.post_type = 'idx-off-market' AND t1.post_status = 'publish'
            AND t2.meta_key = '_flex_token_listing_page_id'
            ");
            foreach ($response['off_market_listings'] as $my_building) {
                if (in_array($my_building['code'], $wp_off_market_listings)) {
                    continue;
                }
                $wp_insert_off_market_listing = wp_insert_post(array(
                    'post_title' => $my_building['name'],
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_name' => $my_building['slug'],
                    'post_author' => $current_user_id,
                    'post_type' => 'idx-off-market'
                ));
                update_post_meta($wp_insert_off_market_listing, '_flex_token_listing_page_id', $my_building['code']);
            }
            // off market listings fin process
            // update buildings
            $wp_agent_buildings = $wpdb->get_col("
            SELECT t2.meta_value
            FROM {$wpdb->posts} t1
            INNER JOIN {$wpdb->postmeta} t2
            ON t1.ID = t2.post_id
            WHERE t1.post_type = 'flex-idx-building' AND t1.post_status = 'publish'
            AND t2.meta_key = '_flex_building_page_id'
            ");
            foreach ($response['agent_buildings'] as $my_building) {
                if (in_array($my_building['code'], $wp_agent_buildings)) {
                    continue;
                }
                $wp_insert_building = wp_insert_post(array(
                    'post_title' => $my_building['name'],
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => $current_user_id,
                    'post_type' => 'flex-idx-building'
                ));
                update_post_meta($wp_insert_building, '_flex_building_page_id', $my_building['code']);
            }


            //SYNCRO FROM CPANEL
            $wp_agent_sub_area = $wpdb->get_col("
            SELECT t2.meta_value
            FROM {$wpdb->posts} t1
            INNER JOIN {$wpdb->postmeta} t2
            ON t1.ID = t2.post_id
            WHERE t1.post_type = 'idx-sub-area' AND t1.post_status = 'publish'
            AND t2.meta_key = '_flex_building_page_id'
            ");
            foreach ($response['agent_sub_areas'] as $my_sub_area) {
                if (in_array($my_sub_area['code'], $wp_agent_sub_area)) {
                    continue;
                }
                $wp_insert_sub_area = wp_insert_post(array(
                    'post_title' => $my_sub_area['name'],
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => $current_user_id,
                    'post_type' => 'idx-sub-area'
                ));
                update_post_meta($wp_insert_sub_area, '_flex_building_page_id', $my_sub_area['code']);
            }


            if ((false === get_option('flex_idx_alerts_keys')) || (false === get_option('flex_idx_alerts_app_id'))) {
                $alert_subscription_client_email = $flex_idx_info['agent']['agent_contact_email_address'];
                $alert_subscription_website_uri = $flex_idx_info['website_url'];
                $alert_subscription_website_name = $flex_idx_info['website_name'];
                $alert_subscription_property_slug = 'detail';
                $alert_subscription_client_phone = $flex_idx_info['agent']['agent_contact_phone_number'];
            }
            update_option('idxboost_registration_key', $api_registration_key);
            update_option('idxboost_client_status', 'active');
            delete_transient('flex_api_access_token');
            set_transient('flex_api_access_token', $response['access_token'], 3500);
            if (!empty($response['notifications_settings'])) {
                $notifications_settings = $response['notifications_settings'];
                update_option('flex_idx_alerts_keys', $notifications_settings['key_alert']);
                update_option('flex_idx_alerts_app_id', $notifications_settings['id_alert']);
                update_option('flex_idx_alerts_url_logo', $notifications_settings['url_logo']);
            }
            if (!empty($response['agent_info'])) { // idxboost_agent_info
                $agent_info = $response['agent_info'];
                update_option('idxboost_agent_info', $agent_info);
            }
            if (!empty($response['pusher_settings'])) { // idxboost_pusher_settings
                $pusher_info = $response['pusher_settings'];
                update_option('idxboost_pusher_settings', $pusher_info);
            }
            if (!empty($response['search_settings'])) { // idxboost_search_settings
                $search_settings = $response['search_settings'];
                update_option('idxboost_search_settings', $search_settings);
            }

            if (isset($response["commercial_types"])) {
                $commercial_types = empty($response["commercial_types"]) ? [] : $response["commercial_types"];
                update_option("idxboost_commercial_types", $commercial_types);
            }
        } else {
            update_option('idxboost_client_status', 'inactive');
            delete_transient('flex_api_access_token');
        }

        if (empty($return_json)) {
            wp_send_json($response);
            exit;
        } else {
            return $response;
        }
    }
}
if (!function_exists('flex_idx_profile_save_xhr_fn')) {
    function flex_idx_profile_save_xhr_fn()
    {
        global $wpdb;
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $response = array();
        $flex_idx_profile_name = isset($_POST['flex_idx_profile_name']) ? sanitize_text_field($_POST['flex_idx_profile_name']) : '';
        $flex_idx_profile_last_name = isset($_POST['flex_idx_profile_last_name']) ? sanitize_text_field($_POST['flex_idx_profile_last_name']) : '';
        $flex_idx_profile_email = isset($_POST['flex_idx_profile_email']) ? sanitize_text_field($_POST['flex_idx_profile_email']) : '';
        $flex_idx_profile_phone = isset($_POST['flex_idx_profile_phone']) ? sanitize_text_field($_POST['flex_idx_profile_phone']) : '';
        $flex_idx_profile_address = isset($_POST['flex_idx_profile_address']) ? sanitize_text_field($_POST['flex_idx_profile_address']) : '';
        $flex_idx_profile_city = isset($_POST['flex_idx_profile_city']) ? sanitize_text_field($_POST['flex_idx_profile_city']) : '';
        $flex_idx_profile_state = isset($_POST['flex_idx_profile_state']) ? sanitize_text_field($_POST['flex_idx_profile_state']) : '';
        $flex_idx_profile_zip = isset($_POST['flex_idx_profile_zip']) ? sanitize_text_field($_POST['flex_idx_profile_zip']) : '';
        $flex_new_password = isset($_POST['new_password']) ? sanitize_text_field($_POST['new_password']) : '';
        $flex_confirm_password = isset($_POST['confirm_password']) ? sanitize_text_field($_POST['confirm_password']) : '';
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data' => array(
                'first_name' => $flex_idx_profile_name,
                'last_name' => $flex_idx_profile_last_name,
                'email_address' => $flex_idx_profile_email,
                'phone_number' => $flex_idx_profile_phone,
                'address' => $flex_idx_profile_address,
                'city' => $flex_idx_profile_city,
                'state' => $flex_idx_profile_state,
                'zip_code' => $flex_idx_profile_zip,
                'new_password' => $flex_new_password,
                'confirm_password' => $flex_confirm_password
            ),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEADS_UPDATE_SETTINGS);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        if (isset($response['success']) && $response['success'] === true) {
            $credentials = implode('|', array($response['lead_info']['email_address'], $response['lead_info']['password']));
            // setcookie('flex_token_login', $credentials, time() + 60 * 60 * 24, COOKIEPATH, COOKIE_DOMAIN, false, true);
        }
        $response['success'] = true;
        $response['message'] = 'All information has been updated successfully';
        $response['params'] = $sendParams;
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_update_search_xhr_fn')) {
    function flex_update_search_xhr_fn()
    {
        global $wpdb, $flex_idx_lead;
        $access_token = flex_idx_get_access_token();
        $response = array();
        $search_url = isset($_POST['search_url']) ? trim(strip_tags($_POST['search_url'])) : '';
        $search_count = isset($_POST['search_count']) ? (int)$_POST['search_count'] : 0;
        $search_query = isset($_POST['search_query']) ? trim($_POST['search_query']) : '';
        $search_name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
        $type = isset($_POST['type']) ? trim(strip_tags($_POST['type'])) : '';
        $object_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $token_alert = isset($_POST['token_alert']) ? trim(strip_tags($_POST['token_alert'])) : null;
        $notification_day = isset($_POST['notification_day']) ? $_POST['notification_day'] : '--';
        $notification_type = isset($_POST['notification_type']) ? $_POST['notification_type'] : [];
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        if ($notification_day == 0) $status_change = 0;
        else $status_change = 1;
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data' => array(
                'search_name' => $search_name,
                'search_url' => $search_url,
                'search_count' => $search_count,
                'object_id' => $object_id,
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'user_agent' => $user_agent,
                'token_alert' => '',
            ),
        );
        switch ($type) {
            case 'update':
                if ($search_name == '') {
                    $response['success'] = false;
                    $response['message'] = 'You must provide a search title to identify your custom search.';
                } else if ($search_count <= 0) {
                    $response['success'] = false;
                    $response['message'] = 'This search does not contain any valid property.';
                } else {
                    if (($notification_day == 7) || ($notification_day == 1 || $notification_day == 30 || $notification_day == 0)) {
                        $listings = [];
                        $save_alert_params = [
                            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                            'rk' => get_option('flex_idx_alerts_keys'),
                            'wp_user_id' => $token_alert,
                            'search_name' => $search_name,
                            'period' => intval($notification_day),
                            'notify_criteria' => json_encode($notification_type),
                            'statusalert' => $status_change,
                        ];
                        $update_alert_q = flex_http_request(FLEX_IDX_ALERTS_UPDATE, $save_alert_params);
                        $response['alert'] = $update_alert_q;
                    }
                }
                $sendParams = array(
                    'access_token' => $access_token,
                    'alert_token' => $token_alert,
                    'search_name' => $search_name,
                    'notification_type' => json_encode($notification_type),
                    'notification_day' => $notification_day,
                    'typeOption' => 'update',
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_TRACK_PROPERTY_LOOK_TOKEN);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);
                $response['cpanel'] = $server_output;
                curl_close($ch);
                break;
        }
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('idxboost_history_building_xhr_fn')) {
    function idxboost_history_building_xhr_fn($building_id)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;
        $access_token = flex_idx_get_access_token();
        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $wp_request = $wp->request;
        $wp_request_exp = explode('/', $wp_request);
        $sendParams = array(
            'filter_id' => $building_id,
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );
        $building_id = md5($building_id);
        $path_feed = FLEX_IDX_PATH . 'feed/';
        $post_building = $path_feed . 'condo_' . $building_id . '.json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDING_COLLECTION_LOOKUP);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $result = file_put_contents($post_building, $server_output);
        return '1';
    }
}
if (!function_exists('get_feed_file_building_history_building_xhr_fn')) {
    function get_feed_file_building_history_building_xhr_fn($building_id)
    {
        $path_feed = FLEX_IDX_PATH . 'feed/';
        $building_id = md5($building_id);
        $post_building = $path_feed . 'condo_' . $building_id . '.json';
        $result = [];

        if (file_exists($post_building)) {
            $result = file_get_contents($post_building);
        }

        return $result;
    }
}


if (!function_exists('idx_force_registration_building_xhr_fn')) {
    function idx_force_registration_building_xhr_fn()
    {
        global $wpdb, $flex_idx_lead, $flex_idx_info;
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $response = array();
        $response['success'] = false;
        $search_count = isset($_POST['search_count']) ? (int)$_POST['search_count'] : 0;
        $search_url = isset($_POST['search_url']) ? trim(strip_tags($_POST['search_url'])) : '';
        $search_query = isset($_POST['query_generate']) ? trim(urldecode($_POST['query_generate'])) : '';
        $search_name = isset($_POST['search_name']) ? trim(strip_tags($_POST['search_name'])) : '';
        $type = '2';
        $object_id = 0;
        $notification_day = 1;

        $lead_name = isset($_POST['lead_name']) ? trim(strip_tags($_POST['lead_name'])) : '';
        $lead_lastname = isset($_POST['lead_lastname']) ? trim(strip_tags($_POST['lead_lastname'])) : '';
        $lead_email = isset($_POST['lead_email']) ? trim(strip_tags($_POST['lead_email'])) : '';

        $search_filter_params = isset($_POST['search_filter_params']) ? $_POST['search_filter_params'] : '';
        $search_condition = isset($_POST['search_condition']) ? trim(strip_tags($_POST['search_condition'])) : '';
        $notification_type = [];
        $notification_type = array("status_change" => true, "price_change" => true, "new_listing" => true);
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $board_id = $flex_idx_info['board_id'];
        $ib_tags = isset($_POST["ib_tags"]) ? trim(strip_tags($_POST["ib_tags"])) : "";
        if (empty($board_id)) $board_id = 1;
        $sendParams = array(
            'ib_tags' => $ib_tags,
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'search_params' => $search_filter_params,
            'data' => array(
                'search_board' => $board_id,
                'search_type' => 'building_filter',
                'search_name' => $search_name,
                'search_url' => $search_url,
                'search_count' => $search_count,
                'object_id' => $object_id,
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'user_agent' => $user_agent,
                'token_alert' => '',
            ),
        );
        if ($search_name == '') {
            $response['success'] = false;
            $response['message'] = 'You must provide a search title to identify your custom search.';
        } else if ($search_count <= 0) {
            $response['success'] = false;
            $response['message'] = 'This search does not contain any valid property.';
        } else {
            if (($notification_day == 7) || ($notification_day == 1 || $notification_day == 30)) {
                $listings = [];
                $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

                if (empty($flex_idx_lead) && is_array($flex_idx_lead) && array_key_exists('lead_info', $flex_idx_lead) && array_key_exists('first_name', $flex_idx_lead['lead_info'])) {
                    $lead_name = $flex_idx_lead['lead_info']['first_name'];
                }
                if (empty($flex_idx_lead) && is_array($flex_idx_lead) && array_key_exists('lead_info', $flex_idx_lead) && array_key_exists('email_address', $flex_idx_lead['lead_info'])) {
                    $lead_email = $flex_idx_lead['lead_info']['email_address'];
                }

                $save_alert_params = [
                    'type_subscription' => 2,
                    'rk' => get_option('flex_idx_alerts_keys'),
                    'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                    'wp_user_name' => $lead_name,
                    'wp_user_email_address' => $lead_email,
                    'period' => intval($notification_day),
                    'search_url' => $search_url,
                    'search_count' => $search_count,
                    'search_name' => $search_name,
                    'search_type' => 'building_filter',
                    'q' => $search_query,
                    'notify_criteria' => json_encode($notification_type),
                    'listings' => json_encode($notification_type),
                    'board' => $board_id,
                ];
                $save_alert_q = flex_http_request(FLEX_IDX_ALERTS_REGISTER, $save_alert_params);
                $sendParams['data']['token_alert'] = $save_alert_q['token_wp_user_client'];
            }

            $sendParams['data']['type'] = 'add';
            $sendParams['data']['name'] = $search_name;
            $sendParams['data']['alert'] = [
                'interval' => $notification_day,
                'notification_types' => $notification_type,
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SEARCH_SAVE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
            $server_output = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($server_output, true);
        }
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('idxboost_new_filter_save_search_xhr_fn')) {
    function idxboost_new_filter_save_search_xhr_fn()
    {
        global $wpdb, $flex_idx_lead, $flex_idx_info;
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $response = array();
        $response['success'] = false;
        $search_url = isset($_POST['search_url']) ? trim(strip_tags($_POST['search_url'])) : '';
        $search_count = isset($_POST['search_count']) ? (int)$_POST['search_count'] : 0;
        $search_query = isset($_POST['search_query']) ? trim(urldecode($_POST['search_query'])) : '';
        $search_name = isset($_POST['search_name']) ? trim(strip_tags($_POST['search_name'])) : '';
        $type = isset($_POST['type']) ? trim(strip_tags($_POST['type'])) : '';
        $more_params = isset($_POST['more_params']) ? trim(strip_tags($_POST['more_params'])) : '';
        $object_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $token_alert = isset($_POST['token_alert']) ? trim(strip_tags($_POST['token_alert'])) : null;
        $notification_day = isset($_POST['notification_day']) ? $_POST['notification_day'] : '--';
        $search_filter_params = isset($_POST['search_filter_params']) ? $_POST['search_filter_params'] : '';
        $search_condition = isset($_POST['search_condition']) ? trim(strip_tags($_POST['search_condition'])) : '';
        $notification_type = isset($_POST['notification_type']) ? $_POST['notification_type'] : [];
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $board_id = $flex_idx_info['board_id'];
        if (empty($board_id)) $board_id = 1;
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'search_params' => $search_filter_params,
            'data' => array(
                'search_board' => $board_id,
                'search_type' => 'search_filter',
                'search_name' => $search_name,
                'search_url' => $search_url,
                'search_count' => $search_count,
                'object_id' => $object_id,
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'user_agent' => $user_agent,
                'token_alert' => '',
            ),
        );
        if ($search_name == '') {
            $response['success'] = false;
            $response['message'] = 'You must provide a search title to identify your custom search.';
        } else if ($search_count <= 0) {
            $response['success'] = false;
            $response['message'] = 'This search does not contain any valid property.';
        } else {
            if (($notification_day == 7) || ($notification_day == 1 || $notification_day == 30)) {
                $listings = [];
                $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
                if (!empty($search_condition))
                    $search_query_alert = str_replace("WHERE", " ", $search_condition);
                $save_alert_params = [
                    'type_subscription' => 2,
                    'rk' => get_option('flex_idx_alerts_keys'),
                    'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                    'wp_user_name' => $flex_idx_lead['lead_info']['first_name'],
                    'wp_user_email_address' => $flex_idx_lead['lead_info']['email_address'],
                    'period' => intval($notification_day),
                    'search_url' => $search_url,
                    'search_count' => $search_count,
                    'search_name' => $search_name,
                    'search_type' => 'search_filter',
                    'q' => $search_query_alert,
                    'notify_criteria' => json_encode($notification_type),
                    'listings' => json_encode($notification_type),
                    'board' => $board_id,
                ];
                $save_alert_q = flex_http_request(FLEX_IDX_ALERTS_REGISTER, $save_alert_params);
                $sendParams['data']['token_alert'] = $save_alert_q['token_wp_user_client'];
            }
            $sendParams['data']['type'] = 'add';
            $sendParams['data']['name'] = $name;
            $sendParams['data']['alert'] = [
                'interval' => $notification_day,
                'notification_types' => $notification_type,
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SEARCH_SAVE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
            $server_output = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($server_output, true);
        }
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('idxboost_filter_save_search_xhr_fn')) {
    function idxboost_filter_save_search_xhr_fn()
    {
        global $wpdb, $flex_idx_lead, $flex_idx_info;
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $response = array();
        $search_url = isset($_POST['search_url']) ? trim(strip_tags($_POST['search_url'])) : '';
        $search_count = isset($_POST['search_count']) ? (int)$_POST['search_count'] : 0;
        $search_query = isset($_POST['search_query']) ? trim($_POST['search_query']) : '';
        $search_name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
        $type = isset($_POST['type']) ? trim(strip_tags($_POST['type'])) : '';
        $search_params = isset($_POST['search_params']) ? trim(strip_tags($_POST['search_params'])) : '';
        $object_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $token_alert = isset($_POST['token_alert']) ? trim(strip_tags($_POST['token_alert'])) : null;
        $notification_day = isset($_POST['notification_day']) ? $_POST['notification_day'] : '--';
        $notification_type = isset($_POST['notification_type']) ? $_POST['notification_type'] : [];
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $board_id = $flex_idx_info['board_id'];
        if (empty($board_id)) $board_id = 1;
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'search_params' => $search_params,
            'data' => array(
                'search_board' => $board_id,
                'search_type' => 'filter',
                'search_name' => $search_name,
                'search_url' => $search_url,
                'search_count' => $search_count,
                'object_id' => $object_id,
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'user_agent' => $user_agent,
                'token_alert' => '',
            ),
        );
        switch ($type) {
            case 'add':
                if ($search_name == '') {
                    $response['success'] = false;
                    $response['message'] = 'You must provide a search title to identify your custom search.';
                } else if ($search_count <= 0) {
                    $response['success'] = false;
                    $response['message'] = 'This search does not contain any valid property.';
                } else {
                    if (($notification_day == 7) || ($notification_day == 1 || $notification_day == 30)) {
                        $listings = [];
                        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
                        $listings_req = flex_http_request(FLEX_IDX_API_FETCH_LISTINGS, [
                            'q' => $search_query,
                            'access_token' => $access_token,
                            'flex_credentials' => $flex_lead_credentials,
                        ]);
                        if (!empty($listings_req)) {
                            $listings = $listings_req;
                        }
                        $search_query_alert = str_replace("WHERE", " ", $search_query);
                        $save_alert_params = [
                            'type_subscription' => 2,
                            'rk' => get_option('flex_idx_alerts_keys'),
                            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                            'wp_user_name' => $flex_idx_lead['lead_info']['first_name'],
                            'wp_user_email_address' => $flex_idx_lead['lead_info']['email_address'],
                            'period' => intval($notification_day),
                            'search_url' => $search_url,
                            'search_count' => $search_count,
                            'search_name' => $search_name,
                            'search_type' => 'filter',
                            'q' => $search_query_alert,
                            'notify_criteria' => json_encode($notification_type),
                            'listings' => json_encode($listings),
                            'board' => $board_id,
                        ];
                        $save_alert_q = flex_http_request(FLEX_IDX_ALERTS_REGISTER, $save_alert_params);
                        $sendParams = array(
                            'access_token' => $access_token,
                            'flex_credentials' => $flex_lead_credentials,
                            'search_params' => $search_params,
                            'data' => array(
                                'search_board' => $board_id,
                                'search_name' => $search_name,
                                'search_url' => $search_url,
                                'search_count' => $search_count,
                                'search_type' => 'filter',
                                'object_id' => $object_id,
                                'ip_address' => $ip_address,
                                'url_referer' => $referer,
                                'url_origin' => $origin,
                                'user_agent' => $user_agent,
                                'token_alert' => $save_alert_q['token_wp_user_client'],
                            ),
                        );
                    }
                    $sendParams['data']['type'] = 'add';
                    $sendParams['data']['name'] = $name;
                    $sendParams['data']['alert'] = [
                        'interval' => $notification_day,
                        'notification_types' => $notification_type,
                    ];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SEARCH_SAVE);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                    $server_output = curl_exec($ch);
                    curl_close($ch);
                    $response = json_decode($server_output, true);
                    if (($notification_day == 7) || ($notification_day == 1)) {
                        if (isset($response['success']) && $response['success'] === true) {
                            $listings = [];
                            $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
                            $listings_req = flex_http_request(FLEX_IDX_API_FETCH_LISTINGS, [
                                'q' => $search_query,
                                'access_token' => $access_token,
                                'flex_credentials' => $flex_lead_credentials,
                            ]);
                            if (!empty($listings_req)) {
                                $listings = $listings_req;
                            }
                        }
                    }
                }
                break;
            case 'remove':
                $sendParams['data']['type'] = 'remove';
                $ch = curl_init();
                $response_alerts = flex_http_request(FLEX_IDX_ALERTS_UNREGISTER, [
                    'rk' => get_option('flex_idx_alerts_keys'),
                    'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                    'wp_user_id' => $token_alert,
                ]);
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SEARCH_SAVE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($server_output, true);
                $response['success'] = true;
                $response['message'] = 'Your saved search has been removed sucessfully';
                break;
            case 'update':
                if ($search_name == '') {
                    $response['success'] = false;
                    $response['message'] = 'You must provide a search title to identify your custom search.';
                } else if ($search_count <= 0) {
                    $response['success'] = false;
                    $response['message'] = 'This search does not contain any valid property.';
                } else {
                    if (($notification_day == 7) || ($notification_day == 1 || $notification_day == 30)) {
                        $listings = [];
                        $save_alert_params = [
                            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                            'rk' => get_option('flex_idx_alerts_keys'),
                            'wp_user_id' => $token_alert,
                            'search_name' => $search_name,
                            'search_type' => 'regular',
                            'period' => intval($notification_day),
                            'notify_criteria' => json_encode($notification_type),
                            'statusalert' => 1,
                            'board' => $board_id,
                        ];
                        $update_alert_q = flex_http_request(FLEX_IDX_ALERTS_UPDATE, $save_alert_params);
                        $response = $update_alert_q;
                    }
                }
                $sendParams = array(
                    'access_token' => $access_token,
                    'flex_credentials' => $flex_lead_credentials,
                    'data' => array(
                        'search_board' => $board_id,
                        'search_name' => $search_name,
                        'search_type' => 'regular',
                        'search_url' => $search_url,
                        'search_count' => $search_count,
                        'object_id' => $object_id,
                        'token_alert' => $token_alert,
                    ),
                );
                $sendParams['data']['type'] = 'update';
                $sendParams['data']['name'] = $name;
                $sendParams['data']['alert'] = [
                    'interval' => $notification_day,
                    'notification_types' => $notification_type,
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SEARCH_UPDATE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);
                curl_close($ch);
                break;
        }
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_save_search_xhr_fn')) {
    function flex_idx_save_search_xhr_fn()
    {
        global $wpdb, $flex_idx_lead, $flex_idx_info;
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $response = array();
        $search_url = isset($_POST['search_url']) ? trim(strip_tags($_POST['search_url'])) : '';
        $search_count = isset($_POST['search_count']) ? (int)$_POST['search_count'] : 0;
        $search_query = isset($_POST['search_query']) ? trim($_POST['search_query']) : '';
        $search_name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
        $type = isset($_POST['type']) ? trim(strip_tags($_POST['type'])) : '';
        $object_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $token_alert = isset($_POST['token_alert']) ? trim(strip_tags($_POST['token_alert'])) : null;
        $notification_day = isset($_POST['notification_day']) ? $_POST['notification_day'] : '--';
        $notification_type = isset($_POST['notification_type']) ? $_POST['notification_type'] : [];
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $board_id = $flex_idx_info['board_id'];
        if (empty($board_id)) $board_id = 1;

        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data' => array(
                'search_board' => $board_id,
                'search_name' => $search_name,
                'search_url' => $search_url,
                'search_count' => $search_count,
                'object_id' => $object_id,
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'search_type' => 'regular',
                'user_agent' => $user_agent,
                'token_alert' => '',
            ),
        );
        switch ($type) {
            case 'add':
                if ($search_name == '') {
                    $response['success'] = false;
                    $response['message'] = 'You must provide a search title to identify your custom search.';
                } else if ($search_count <= 0) {
                    $response['success'] = false;
                    $response['message'] = 'This search does not contain any valid property.';
                } else {
                    if (($notification_day == 7) || ($notification_day == 1 || $notification_day == 30)) {
                        $listings = [];
                        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
                        $listings_req = flex_http_request(FLEX_IDX_API_FETCH_LISTINGS, [
                            'q' => $search_query,
                            'access_token' => $access_token,
                            'flex_credentials' => $flex_lead_credentials,
                        ]);
                        if (!empty($listings_req)) {
                            $listings = $listings_req;
                        }
                        $search_query_alert = str_replace("WHERE", " ", $search_query);
                        $save_alert_params = [
                            'type_subscription' => 2,
                            'rk' => get_option('flex_idx_alerts_keys'),
                            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                            'wp_user_name' => $flex_idx_lead['lead_info']['first_name'],
                            'wp_user_email_address' => $flex_idx_lead['lead_info']['email_address'],
                            'period' => intval($notification_day),
                            'search_url' => $search_url,
                            'search_count' => $search_count,
                            'search_name' => $search_name,
                            'search_type' => 'regular',
                            'q' => $search_query_alert,
                            'notify_criteria' => json_encode($notification_type),
                            'listings' => json_encode($listings),
                            'board' => $board_id,
                        ];
                        $save_alert_q = flex_http_request(FLEX_IDX_ALERTS_REGISTER, $save_alert_params);
                        $sendParams = array(
                            'access_token' => $access_token,
                            'flex_credentials' => $flex_lead_credentials,
                            'data' => array(
                                'search_board' => $board_id,
                                'search_name' => $search_name,
                                'search_url' => $search_url,
                                'search_count' => $search_count,
                                'object_id' => $object_id,
                                'ip_address' => $ip_address,
                                'url_referer' => $referer,
                                'search_type' => 'regular',
                                'url_origin' => $origin,
                                'user_agent' => $user_agent,
                                'token_alert' => $save_alert_q['token_wp_user_client'],
                            ),
                        );
                    }
                    $sendParams['data']['type'] = 'add';
                    $sendParams['data']['name'] = $name;
                    $sendParams['data']['alert'] = [
                        'interval' => $notification_day,
                        'notification_types' => $notification_type,
                    ];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SEARCH_SAVE);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                    $server_output = curl_exec($ch);
                    curl_close($ch);
                    $response = json_decode($server_output, true);
                    if (($notification_day == 7) || ($notification_day == 1)) {
                        if (isset($response['success']) && $response['success'] === true) {
                            $listings = [];
                            $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
                            $listings_req = flex_http_request(FLEX_IDX_API_FETCH_LISTINGS, [
                                'q' => $search_query,
                                'access_token' => $access_token,
                                'flex_credentials' => $flex_lead_credentials,
                            ]);
                            if (!empty($listings_req)) {
                                $listings = $listings_req;
                            }
                        }
                    }
                }
                break;
            case 'remove':
                // track save_search remove [start]
                $sendParams['data']['type'] = 'remove';
                $ch = curl_init();
                $response_alerts = flex_http_request(FLEX_IDX_ALERTS_UNREGISTER, [
                    'rk' => get_option('flex_idx_alerts_keys'),
                    'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                    'wp_user_id' => $token_alert,
                ]);
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SEARCH_SAVE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($server_output, true);
                // track save_search remove [end]
                $response['success'] = true;
                $response['message'] = 'Your saved search has been removed sucessfully';
                break;
            case 'update':
                if ($search_name == '') {
                    $response['success'] = false;
                    $response['message'] = 'You must provide a search title to identify your custom search.';
                } else if ($search_count <= 0) {
                    $response['success'] = false;
                    $response['message'] = 'This search does not contain any valid property.';
                } else {
                    if (($notification_day == 7) || ($notification_day == 1 || $notification_day == 30 || $notification_day == "0")) {
                        $listings = [];
                        $statusalert = "1";
                        if ($notification_day == "0") {
                            $statusalert = "0";
                            $notification_day_alert = "1";
                        }

                        $save_alert_params = [
                            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                            'rk' => get_option('flex_idx_alerts_keys'),
                            'wp_user_id' => $token_alert,
                            'search_name' => $search_name,
                            'period' => intval($notification_day_alert),
                            'notify_criteria' => json_encode($notification_type),
                            'statusalert' => $statusalert,
                            'board' => $board_id,
                        ];
                        $update_alert_q = flex_http_request(FLEX_IDX_ALERTS_UPDATE, $save_alert_params);
                        $response = $update_alert_q;
                    }
                }
                $sendParams = array(
                    'access_token' => $access_token,
                    'flex_credentials' => $flex_lead_credentials,
                    'data' => array(
                        'search_board' => $board_id,
                        'search_name' => $search_name,
                        'search_url' => $search_url,
                        'search_count' => $search_count,
                        'object_id' => $object_id,
                        'token_alert' => $token_alert,
                    ),
                );
                $sendParams['data']['type'] = 'update';
                $sendParams['data']['name'] = $name;
                $sendParams['data']['alert'] = [
                    'interval' => $notification_day,
                    'notification_types' => $notification_type,
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SEARCH_UPDATE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);
                curl_close($ch);
                break;
        }
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_favorite_comments_xhr_fn')) {
    function flex_idx_favorite_comments_xhr_fn()
    {
        global $wpdb;
        $response = array();
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $mls = isset($_POST['mls']) ? sanitize_text_field($_POST['mls']) : '';
        $comment = isset($_POST['comment']) ? sanitize_text_field($_POST['comment']) : '';
        $type_action = isset($_POST['type_action']) ? sanitize_text_field($_POST['type_action']) : '';
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'mls_num' => $mls,
            'comment' => $comment,
            'type_action' => $type_action,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITES_COMMENT);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_favorite_rate_xhr_fn')) {
    function flex_idx_favorite_rate_xhr_fn()
    {
        global $wpdb;
        $access_token = flex_idx_get_access_token();
        $response = array();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $user_id = $flex_credentials_exp[0];
        $mls = isset($_POST['mls']) ? sanitize_text_field($_POST['mls']) : '';
        $count = isset($_POST['count']) ? (int)$_POST['count'] : '';
        // track on cpanel
        $sendParams = array(
            'access_token' => $access_token,
            'mls_num' => $mls,
            'count' => $count,
            'flex_credentials' => $flex_lead_credentials,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITES_RATE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        // end track on cpanel
        $response['success'] = true;
        $response['message'] = 'Favorite rating updated successfully';
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_favorite_comments_remove_xhr_fn')) {
    function flex_idx_favorite_comments_remove_xhr_fn()
    {
        global $wpdb;
        $response = array();
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $mls = isset($_POST['mls']) ? sanitize_text_field($_POST['mls']) : '';
        $comment = isset($_POST['comment']) ? sanitize_text_field($_POST['comment']) : '';
        $type_action = 'remove';
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'mls_num' => $mls,
            'type_action' => $type_action,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITES_COMMENT);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_favorite_building_xhr_fn')) {
    function flex_idx_favorite_building_xhr_fn()
    {
        global $wpdb;
        $response = array();
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $type_action = isset($_POST['type_action']) ? trim(strip_tags($_POST['type_action'])) : '';
        $building_id = isset($_POST['building_id']) ? trim(strip_tags($_POST['building_id'])) : null;
        $building_permalink = isset($_POST['building_permalink']) ? trim(strip_tags($_POST['building_permalink'])) : null;
        $user_id = $flex_credentials_exp[0];
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data' => array(
                'building_id' => $building_id,
                'building_permalink' => $building_permalink,
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'user_agent' => $user_agent,
                'type_property' => 2,
            ),
        );
        switch ($type_action) {
            case 'add':
                // track favorite add [start]
                $sendParams['data']['type'] = 'add';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITE_SAVE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($server_output, true);
                // track favorite add [end]
                $response['success'] = true;
                $response['message'] = 'Building added as favorite successfully.';
                break;
            case 'remove':
                // track favorite add [start]
                $sendParams['data']['type'] = 'remove';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITE_SAVE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                curl_exec($ch);
                curl_close($ch);
                // track favorite add [end]
                $response['success'] = true;
                $response['message'] = 'Building removed from favorites sucessfully.';
                break;
        }
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('flex_statistics_filter_sold_xhr_fn')) {
    function flex_statistics_filter_sold_xhr_fn()
    {
        global $wpdb;
        $response = ['status' => false];
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $page = isset($_POST['page']) ? trim(strip_tags($_POST['page'])) : '1';
        $class_id = isset($_POST['class_id']) ? trim(strip_tags($_POST['class_id'])) : '';
        $city_id = isset($_POST['city_id']) ? trim(strip_tags($_POST['city_id'])) : '';
        $price_min = isset($_POST['price_min']) ? trim(strip_tags($_POST['price_min'])) : '';
        $price_max = isset($_POST['price_max']) ? trim(strip_tags($_POST['price_max'])) : '';
        $property_type = isset($_POST['property_type']) ? trim(strip_tags($_POST['property_type'])) : '';
        $property_style = isset($_POST['property_style']) ? trim(strip_tags($_POST['property_style'])) : '';
        $order = isset($_POST['order']) ? trim(strip_tags($_POST['order'])) : 'list_date-desc';
        $close_date_start = isset($_POST['close_date_start']) ? trim(strip_tags($_POST['close_date_start'])) : '';
        $close_date_end = isset($_POST['close_date_end']) ? trim(strip_tags($_POST['close_date_end'])) : '';

        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'page' => $page,
            'class_id' => $class_id,
            'city_id' => $city_id,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'property_type' => $property_type,
            'property_style' => $property_style,
            'order' => $order,
            'close_date_start' => $close_date_start,
            'close_date_end' => $close_date_end,
            'ip_address' => $ip_address,
            'url_referer' => $referer,
            'url_origin' => $origin,
            'user_agent' => $user_agent,
            'type_property' => 3,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_BASE_STATISTICS);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);

        wp_send_json($response);
        exit;
    }
}

if (!function_exists('flex_favorite_sub_area_xhr_fn')) {
    function flex_favorite_sub_area_xhr_fn()
    {
        global $wpdb;
        $response = array();
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $type_action = isset($_POST['type_action']) ? trim(strip_tags($_POST['type_action'])) : '';
        $building_id = isset($_POST['building_id']) ? trim(strip_tags($_POST['building_id'])) : null;
        $building_permalink = isset($_POST['building_permalink']) ? trim(strip_tags($_POST['building_permalink'])) : null;
        $user_id = $flex_credentials_exp[0];
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data' => array(
                'subarea_id' => $building_id,
                'subarea_permalink' => $building_permalink,
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'user_agent' => $user_agent,
                'type_property' => 3,
            ),
        );
        switch ($type_action) {
            case 'add':
                // track favorite add [start]
                $sendParams['data']['type'] = 'add';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITE_SAVE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($server_output, true);
                // track favorite add [end]
                $response['success'] = true;
                $response['message'] = 'Sub Area added as favorite successfully.';
                break;
            case 'remove':
                // track favorite add [start]
                $sendParams['data']['type'] = 'remove';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITE_SAVE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                curl_exec($ch);
                curl_close($ch);
                // track favorite add [end]
                $response['success'] = true;
                $response['message'] = 'Sub Area removed from favorites sucessfully.';
                break;
        }
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('ib_hide_listing_view_xhr_fn')) {
    function ib_hide_listing_view_xhr_fn()
    {

        global $wpdb, $flex_idx_info, $flex_idx_lead;

        $response = array();

        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $mls_num = isset($_POST['mls_num']) ? trim(strip_tags($_POST['mls_num'])) : null;
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'mls_num' => $mls_num
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LEAD_HIDE_LISTING);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);

        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('flex_idx_favorite_xhr_fn')) {
    function flex_idx_favorite_xhr_fn()
    {
        global $wpdb, $flex_idx_info, $flex_idx_lead;
        $response = array();
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $type_action = isset($_POST['type_action']) ? trim(strip_tags($_POST['type_action'])) : '';
        $mls_num = isset($_POST['mls_num']) ? trim(strip_tags($_POST['mls_num'])) : null;
        $subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : '';
        $address_search = isset($_POST['address_search']) ? trim(strip_tags($_POST['address_search'])) : null;
        $token_alert = isset($_POST['token_alert']) ? trim(strip_tags($_POST['token_alert'])) : null;
        $search_url = isset($_POST['search_url']) ? trim(strip_tags($_POST['search_url'])) : null;
        $user_id = $flex_credentials_exp[0];
        $client_ip = get_client_ip_server();
        $url_referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $url_origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data' => array(
                'mls_num' => $mls_num,
                'client_ip' => $client_ip,
                'url_referer' => $url_referer,
                'url_origin' => $url_origin,
                'user_agent' => $user_agent,
                'type_property' => 1
            ),
        );
        switch ($type_action) {
            case 'add':
                $response_alerts = flex_http_request(FLEX_IDX_ALERTS_REGISTER, [
                    'type_subscription' => 1,
                    'search_name' => 'Property update on : ' . $subject,
                    'rk' => get_option('flex_idx_alerts_keys'),
                    'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                    'wp_user_name' => $flex_idx_lead['lead_info']['first_name'],
                    'wp_user_email_address' => $flex_idx_lead['lead_info']['email_address'],
                    'period' => 1,
                    'mls_num' => $mls_num,
                    'search_url' => $search_url,
                    'notify_criteria' => json_encode(["price_change", "status_change", "new_listing"]),
                ]);
                $sendParams = array(
                    'access_token' => $access_token,
                    'flex_credentials' => $flex_lead_credentials,
                    'data' => array(
                        'mls_num' => $mls_num,
                        'class_id' => $class_id,
                        'client_ip' => $client_ip,
                        'url_referer' => $url_referer,
                        'url_origin' => $url_origin,
                        'user_agent' => $user_agent,
                        'type_property' => 1,
                        'token_alert' => $response_alerts['token_wp_user_client'],
                    ),
                );
                $sendParams['data']['type'] = 'add';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITE_SAVE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);

                curl_close($ch);
                $response = json_decode($server_output, true);
                // track favorite add [end]
                break;
            case 'remove':
                // track favorite add [start]
                $sendParams['data']['type'] = 'remove';
                $ch = curl_init();
                $response_alerts = flex_http_request(FLEX_IDX_ALERTS_UNREGISTER, [
                    'rk' => get_option('flex_idx_alerts_keys'),
                    'wp_web_id' => get_option('flex_idx_alerts_app_id'),
                    'wp_user_id' => $token_alert,
                ]);
                curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITE_SAVE);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
                $server_output = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($server_output, true);
                break;
        }
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_request_property_form_fn')) {
    function flex_idx_request_property_form_fn()
    {
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email_address = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $phone_number = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $gender = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $comments = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
        $mls_num = isset($_POST['mls_num']) ? sanitize_text_field($_POST['mls_num']) : '';
        $price = isset($_POST['price']) ? sanitize_text_field($_POST['price']) : '';
        $permalink = isset($_POST['origin']) ? sanitize_text_field($_POST['origin']) : '';
        $flex_idx_type_form = isset($_POST['flex_idx_type_form']) ? sanitize_text_field($_POST['flex_idx_type_form']) : '';
        $flex_idx_address = isset($_POST['flex_idx_address']) ? sanitize_text_field($_POST['flex_idx_address']) : '';
        $client_ip = get_client_ip_server();
        $url_referer = isset($_SERVER['HTTP_REFERER']) ? sanitize_text_field($_SERVER['HTTP_REFERER']) : '';
        $url_origin = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field($_SERVER['HTTP_HOST']) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '';
        $tags = isset($_POST["ib_tags"]) ? trim(strip_tags($_POST["ib_tags"])) : "";
        $access_token = flex_idx_get_access_token();
        $lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $recaptcha_response = isset($_POST["recaptcha_response"]) ? trim(strip_tags($_POST["recaptcha_response"])) : "";

        $sendParams = array(
            'ib_tags' => $tags,
            'recaptcha_response' => $recaptcha_response,
            'data' => array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $gender,
                'email_address' => $email_address,
                'phone_number' => $phone_number,
                'comments' => $comments,
                'mls_num' => $mls_num,
                'price' => $price,
                'address_short' => $flex_idx_address,
                'url_origin' => $url_origin,
                'client_ip' => $client_ip,
                'url_referer' => $url_referer,
                'permalink' => $permalink,
                'user_agent' => $user_agent
            ),
            'lead_credentials' => $lead_credentials,
            'access_token' => $access_token
        );
        $ch = curl_init();
        $endpointinquire = FLEX_IDX_API_INQUIRY_PROPERTY_FORM;
        if (!empty($flex_idx_type_form))
            if ($flex_idx_type_form == 'off_market_listing')
                $endpointinquire = FLEX_IDX_API_INQUIRY_OFF_MARKET_LISTING_FORM;

        curl_setopt($ch, CURLOPT_URL, $endpointinquire);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);

        // echo $server_output;
        // exit;

        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
// Function to get the client ip address
function get_client_ip_server()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : "";
    $forward = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : "";
    $remote = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
}

if (!function_exists('flex_track_property_detail_fn')) {
    function flex_track_property_detail_fn()
    {
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $mls_num = isset($_POST['mls_num']) ? trim(strip_tags($_POST['mls_num'])) : '';
        $price = isset($_POST['price']) ? trim(strip_tags($_POST['price'])) : '';
        $sendParams = array(
            'access_token' => $access_token,
            'data' => array(
                'flex_credentials' => $flex_lead_credentials,
                'ip_address' => $ip_address,
                'referer' => $referer,
                'user_agent' => $user_agent,
                'mls_num' => $mls_num,
                'price' => $price,
            ),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_TRACK_PROPERTY_DETAIL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('idxboost_contact_inquiry_fn')) {
    function idxboost_contact_inquiry_fn()
    {
        $first_name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $last_name = isset($_POST['lastname']) ? sanitize_text_field($_POST['lastname']) : '';
        $email_address = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $phone_number = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $time_to_reach = isset($_POST['option_time']) ? sanitize_text_field($_POST['option_time']) : '';
        $comments = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
        $gender = isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '';
        $receive_newsletter = isset($_POST['chk']) ? '1' : '0';
        $client_ip = get_client_ip_server();
        $url_referer = isset($_SERVER['HTTP_REFERER']) ? sanitize_text_field($_SERVER['HTTP_REFERER']) : '';
        $url_origin = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field($_SERVER['HTTP_HOST']) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '';
        $access_token = flex_idx_get_access_token();
        $lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $tags = isset($_POST["ib_tags"]) ? trim(strip_tags($_POST["ib_tags"])) : "";
        $recaptcha_response = isset($_POST["recaptcha_response"]) ? trim(strip_tags($_POST["recaptcha_response"])) : "";

        $custom_form_heading = isset($_POST['custom_form_heading']) ? trim(strip_tags($_POST['custom_form_heading'])) : "";
        $is_custom_form = isset($_POST['is_custom_form']) ? "yes" : "no";

        $sendParams = array(
            'ib_tags' => $tags,
            'recaptcha_response' => $recaptcha_response,
            'data' => array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $gender,
                'email_address' => $email_address,
                'phone_number' => $phone_number,
                'time_to_reach' => $time_to_reach,
                'comments' => $comments,
                'receive_newsletter' => $receive_newsletter,
                'client_ip' => $client_ip,
                'url_referer' => $url_referer,
                'url_origin' => $url_origin,
                'user_agent' => $user_agent,
                'custom_form_heading' => $custom_form_heading,
                'is_custom_form' => $is_custom_form
            ),
            'lead_credentials' => $lead_credentials,
            'access_token' => $access_token,
            'server' => $_SERVER
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_INQUIRY_CONTACT_FORM);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);

        // echo $server_output;
        // exit;

        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_request_website_building_form_fn')) {
    function flex_idx_request_website_building_form_fn()
    {
        $building_ID = isset($_POST['building_ID']) ? intval($_POST['building_ID']) : 0;
        $building_token_ID = get_post_meta($building_ID, '_flex_building_page_id', true);
        $first_name = isset($_POST['first_name']) ? trim(strip_tags($_POST['first_name'])) : '';
        $last_name = isset($_POST['last_name']) ? trim(strip_tags($_POST['last_name'])) : '';
        $email = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';
        $phone = isset($_POST['phone']) ? trim(strip_tags($_POST['phone'])) : '';
        $message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';
        $ip_address = get_client_ip_server();
        $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $slug = isset($_POST['slug']) ? $_POST['slug'] : null;
        $tags = isset($_POST["ib_tags"]) ? trim(strip_tags($_POST["ib_tags"])) : "";
        $building_price_range = isset($_POST['building_price_range']) ? $_POST['building_price_range'] : '';
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $recaptcha_response = isset($_POST["recaptcha_response"]) ? trim(strip_tags($_POST["recaptcha_response"])) : "";
        $sendParams = array(
            'ib_tags' => $tags,
            'recaptcha_response' => $recaptcha_response,
            'data' => array(
                'building_id' => $building_token_ID,
                'building_price_range' => $building_price_range,
                'slug' => $slug,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'message' => $message,
                'ip_address' => $ip_address,
                'url_referer' => $referer,
                'url_origin' => $origin,
                'user_agent' => $user_agent,
            ),
            'flex_credentials' => $flex_lead_credentials,
            'access_token' => $access_token,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_INQUIRY_BUILDING_FORM);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);

        // echo $server_output;
        // exit;

        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_search_xhr_fn')) {
    function flex_idx_search_xhr_fn()
    {
        $params = isset($_POST['idx']) ? $_POST['idx'] : array();
        $access_token = flex_idx_get_access_token();
        $lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $client_ip = get_client_ip_server();
        $url_referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $url_origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
        $sendParams = array(
            'idx' => $params,
            'access_token' => $access_token,
            'flex_credentials' => $lead_credentials,
            'data' => array(
                'client_ip' => $client_ip,
                'url_referer' => $url_referer,
                'url_origin' => $url_origin,
                'user_agent' => $user_agent
            ),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SEARCH);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('ib_boost_commercial_xhr_fn')) {
    function ib_boost_commercial_xhr_fn()
    {
        global $wp, $wpdb;
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'office_id' => $_POST["office_id"],
            'agen_id' => $_POST["agen_id"],
            'property_sub_class' => $_POST["property_sub_class"],
            'property_status' => $_POST["property_status"],
            'is_rental' => $_POST["is_rental"],
            'price_min' => $_POST["price_min"],
            'price_max' => $_POST["price_max"],
            'order_by' => $_POST["order_by"],
            'limit' => $_POST["limit_carousel"],
            'page' => $_POST["page"]
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_MARKET_EXCLUSIVE_LISTINGS_COMMERCIAL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        $response = json_decode($server_output, true);
        curl_close($ch);
        ob_start();
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('ib_boost_dinamic_data_xhr_fn')) {
    function ib_boost_dinamic_data_xhr_fn()
    {
        global $wp, $wpdb;
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'office_id' => $_POST["office_id"],
            'months_back' => $_POST["months_back"],
            'agent_id' => $_POST["agent_id"],
            'property_sub_class' => $_POST["property_sub_class"],
            'property_status' => $_POST["property_status"],
            'is_rental' => $_POST["is_rental"],
            'price_min' => $_POST["price_min"],
            'price_max' => $_POST["price_max"],
            'order_by' => $_POST["order_by"],
            'limit' => $_POST["limit_carousel"],
            'page' => $_POST["page"]
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_MARKET_AGENT_OFFICE_LISTINGS_SOLD);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        $response = json_decode($server_output, true);
        curl_close($ch);
        ob_start();
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('ib_boost_dinamic_data_agent_office_xhr_fn')) {
    function ib_boost_dinamic_data_agent_office_xhr_fn()
    {
        global $wp, $wpdb;
        $access_token = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'office_id' => $_POST["office_id"],
            'months_back' => $_POST["months_back"],
            'agent_id' => $_POST["agent_id"],
            'property_sub_class' => $_POST["property_sub_class"],
            'property_status' => $_POST["property_status"],
            'is_rental' => $_POST["is_rental"],
            'price_min' => $_POST["price_min"],
            'price_max' => $_POST["price_max"],
            'order_by' => $_POST["order_by"],
            'limit' => $_POST["limit_carousel"],
            'page' => $_POST["page"]
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_MARKET_AGENT_OFFICE_LISTINGS);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        $response = json_decode($server_output, true);
        curl_close($ch);
        ob_start();
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('flex_look_building_xhr_fn')) {
    function flex_look_building_xhr_fn()
    {
        global $wp, $wpdb;
        $access_token = flex_idx_get_access_token();
        if (isset($_POST['filter_id'])) {
            $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
            $wp_request = $wp->request;
            $wp_request_exp = explode('/', $wp_request);
            $valid_sortings = array('order-price-desc', 'order-price-asc', 'order-bed-desc', 'order-bed-asc', 'order-sqft-desc', 'order-sqft-asc', 'order-year-desc', 'order-year-asc', 'order-list_date-desc', 'order-list_date-asc');
            $valid_views = array('view-grid', 'view-list', 'view-map');
            $order = (isset($wp_request_exp[1]) && in_array($wp_request_exp[1], $valid_sortings)) ? $wp_request_exp[1] : '';
            $view = (isset($wp_request_exp[2]) && in_array($wp_request_exp[2], $valid_views)) ? $wp_request_exp[2] : '';
            $sendParams = array(
                'filter_id' => $_POST['filter_id'],
                'access_token' => $access_token,
                'flex_credentials' => $flex_lead_credentials,
            );
            wp_enqueue_style('flex-idx-filter-pages-css');
            wp_enqueue_script('flex-idx-filter-js');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDING_LOOKUP);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
            $server_output = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($server_output, true);
            $agent_info_name = $wpdb->get_var('SELECT `value` FROM flex_idx_settings WHERE `key` = "agent_first_name" LIMIT 1');
            $agent_last_name = $wpdb->get_var('SELECT `value` FROM flex_idx_settings WHERE `key` = "agent_last_name" LIMIT 1');
            $agent_info_photo = $wpdb->get_var('SELECT `value` FROM flex_idx_settings WHERE `key` = "agent_contact_photo_profile" LIMIT 1');
            $agent_info_phone = $wpdb->get_var('SELECT `value` FROM flex_idx_settings WHERE `key` = "agent_phone_number" LIMIT 1');
            $agent_info_email = $wpdb->get_var('SELECT `value` FROM flex_idx_settings WHERE `key` = "agent_email_address" LIMIT 1');
            ob_start();
            wp_send_json($response);
            exit;
        }
    }
}
function filter_search_recent_sales_xhr_fn()
{
    $params = isset($_POST['idx']) ? $_POST['idx'] : array();
    $filter_ID = isset($_POST['filter_ID']) ? (int)$_POST['filter_ID'] : 0;
    $filter_type = isset($_POST['filter_type']) ? (int)$_POST['filter_type'] : 0;
    if (!empty($_POST['limit'])) $limit = $_POST['limit'];
    else     $limit = 'default';
    $access_token = flex_idx_get_access_token();
    $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
    $flex_credentials_exp = explode('|', $flex_lead_credentials);
    $ip_address = get_client_ip_server();
    $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
    $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
    $filter_token_ID = get_post_meta($filter_ID, '_flex_filter_page_id', true);
    $filter_listing_type = get_post_meta($filter_ID, '_flex_filter_page_fl', true);
    if (empty($filter_token_ID)) {
        $filter_token_ID = $_POST['filter_panel'];
    }
    if ('' != $filter_token_ID) {
        $filter_listing_type = 0;
    }
    if (empty($filter_listing_type) || $filter_listing_type == false) {
        $filter_listing_type = $filter_type;
    }
    $sendParams = array(
        'idx' => $params,
        'access_token' => $access_token,
        'flex_credentials' => $flex_lead_credentials,
        'data' => array(
            'ip_address' => $ip_address,
            'url_referer' => $referer,
            'url_origin' => $origin,
            'user_agent' => $user_agent,
        ),
        'limit' => $limit,
        'filter_id' => $filter_token_ID,
        'listing_type' => $filter_listing_type,
        'page' => isset($params['page']) ? (int)$params['page'] : 1,
        'view' => isset($params['view']) ? $params['view'] : 'grid',
        'sort' => isset($params['sort']) ? $params['sort'] : 'price-desc',
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_MARKET_RECENT_SALE);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
    $server_output = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($server_output, true);
    wp_send_json($response);
    exit;
}

if (!function_exists('idxboost_collection_list_fn')) {
    function idxboost_collection_list_fn()
    {
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $access_token = flex_idx_get_access_token();
        $filter_id = $_POST['building_id'];
        $limit = $_POST['limit'];
        $building_id = md5($filter_id);
        $path_feed = FLEX_IDX_PATH . 'feed/';

        $sendParams = array(
            'filter_id' => $filter_id,
            'access_token' => $access_token,
            'limit' => $limit,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDING_COLLECTION_LOOKUP);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        $post_building = $path_feed . 'condo_' . $building_id . '.json';
        file_put_contents($post_building, $server_output);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('idxboost_sub_area_collection_list_fn')) {
    function idxboost_sub_area_collection_list_fn()
    {
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $access_token = flex_idx_get_access_token();
        $filter_id = $_POST['building_id'];
        $idxrequest = $_POST['idxrequest'];

        $sendParams = array(
            'filter_id' => $filter_id,
            'idxrequest' => $idxrequest,
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SUB_AREA_COLLECTION_LOOKUP);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        $response = json_decode($server_output, true);
        curl_close($ch);
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('ib_slider_filter_regular_xhr_fn')) {
    function ib_slider_filter_regular_xhr_fn()
    {
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $access_token = flex_idx_get_access_token();
        $type_filter = $_POST['type_filter'];
        $id_filter = $_POST['id_filter'];
        $limit = $_POST['limit'];

        if (empty($limit) || (is_numeric($limit) && intval($limit) == 0) || !is_numeric($limit)) {
            $limit = "default";
        }


        $sendParams = array(
            'filter_id' => $id_filter,
            'listing_type' => $type_filter,
            //'order' => $order,
            'order' => 'price-desc',
            'mode' => 'slider',
            'idx' => [],
            'access_token' => $access_token,
            'version_endpoint' => 'new',
            'limit' => $limit,
            'flex_credentials' => $flex_lead_credentials
        );

        $endpointFilter = FLEX_IDX_API_MARKET;
        if ($type_filter == '2') {
            $endpointFilter = FLEX_IDX_API_MARKET_EXCLUSIVE_LISTINGS;
        } elseif ($type_filter == '1') {
            $endpointFilter = FLEX_IDX_API_MARKET_RECENT_SALE;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpointFilter);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        $response = json_decode($server_output, true);

        curl_close($ch);
        echo wp_send_json($response);
        exit;
    }
}

if (!function_exists('filter_agent_office_xhr_fn')) {
    function filter_agent_office_xhr_fn()
    {
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $access_token = flex_idx_get_access_token();
        $params = isset($_POST['idx']) ? $_POST['idx'] : array();
        $filter_id = $_POST['filter_id'];
        $typefilt = isset($_POST['listing_type']) ? (int)$_POST['listing_type'] : 4;

        $order = null;
        $view = '';
        $page = 1;
        $param_url = [];
        $sale_type = [];

        if (!empty($sale_type_param)) {
            $sale_type[] = $sale_type_param;
        }

        if (is_array($params) && array_key_exists('page', $params)) {
            $page = $params['page'];
        }

        $sendParams = array(
            'filter_id' => $filter_id,
            'listing_type' => $typefilt,
            'order' => $order,
            'idx' => $params,
            'view' => $view,
            'page' => $page,
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_TRACK_PROPERTY_AGENT_OR_OFFICE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('idxboost_collection_off_market_fn')) {
    function idxboost_collection_off_market_fn()
    {
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $access_token = flex_idx_get_access_token();
        $market_order = isset($_POST['market_order']) ? ($_POST['market_order']) : '';
        $market_page = isset($_POST['market_page']) ? ($_POST['market_page']) : '1';
        $market_tag = isset($_POST['market_tag']) ? ($_POST['market_tag']) : 'default';
        $market_limit = isset($_POST['market_limit']) ? ($_POST['market_limit']) : 'default';

        $sendParams = array(
            'access_token' => $access_token,
            'market_order' => $market_order,
            'market_page' => $market_page,
            'market_tag' => $market_tag,
            'market_limit' => $market_limit,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LOOKUP_OFF_MARKET_LISTING_COLLECTION);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}

if (!function_exists('idx_exclusive_operation_slider_xhr_fn')) {
    function idx_exclusive_operation_slider_xhr_fn($type, $id, $sale_type_param)
    {
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $access_token = flex_idx_get_access_token();

        $order = null;
        $view = '';
        $page = 1;
        $param_url = [];
        $sale_type = [];

        if (!empty($sale_type_param)) {
            $sale_type[] = $sale_type_param;
        }


        $sendParams = array(
            'filter_id' => $id,
            'listing_type' => $type,
            'limit' => 'default',
            'order' => $order,
            'sale_type' => $sale_type,
            'view' => $view,
            'page' => $page,
            'idx' => $param_url,
            'access_token' => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $endpointFilter = FLEX_IDX_API_MARKET;
        if ($type == '2') {
            $endpointFilter = FLEX_IDX_API_MARKET_EXCLUSIVE_LISTINGS;
        } elseif ($$type == '1') {
            $endpointFilter = FLEX_IDX_API_MARKET_RECENT_SALE;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpointFilter);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);

        $response = json_decode($server_output, true);
        return $response;
    }
}

function filter_search_exclusive_listing_xhr_fn()
{
    $params = isset($_POST['idx']) ? $_POST['idx'] : array();
    $filter_ID = isset($_POST['filter_ID']) ? (int)$_POST['filter_ID'] : 0;
    $filter_type = isset($_POST['filter_type']) ? (int)$_POST['filter_type'] : 0;
    if (!empty($_POST['limit'])) $limit = $_POST['limit'];
    else     $limit = 'default';
    $access_token = flex_idx_get_access_token();
    $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
    $flex_credentials_exp = explode('|', $flex_lead_credentials);
    $ip_address = get_client_ip_server();
    $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
    $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
    $filter_token_ID = get_post_meta($filter_ID, '_flex_filter_page_id', true);
    $filter_listing_type = get_post_meta($filter_ID, '_flex_filter_page_fl', true);
    if (empty($filter_token_ID)) {
        $filter_token_ID = $_POST['filter_panel'];
    }
    if ('' != $filter_token_ID) {
        $filter_listing_type = 0;
    }
    if (empty($filter_listing_type) || $filter_listing_type == false) {
        $filter_listing_type = $filter_type;
    }
    $sendParams = array(
        'idx' => $params,
        'access_token' => $access_token,
        'flex_credentials' => $flex_lead_credentials,
        'data' => array(
            'ip_address' => $ip_address,
            'url_referer' => $referer,
            'url_origin' => $origin,
            'user_agent' => $user_agent,
        ),
        'limit' => $limit,
        'filter_id' => $filter_token_ID,
        'listing_type' => $filter_listing_type,
        'page' => isset($params['page']) ? (int)$params['page'] : 1,
        'view' => isset($params['view']) ? $params['view'] : 'grid',
        'sort' => isset($params['sort']) ? $params['sort'] : 'price-desc',
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_MARKET_EXCLUSIVE_LISTINGS);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
    $server_output = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($server_output, true);
    wp_send_json($response);
    exit;
}

if (!function_exists('idxboost_get_data_slider_xhr_fn')) {
    function idxboost_get_data_slider_xhr_fn()
    {
        global $wp, $wpdb, $flex_idx_info;
        $response = [];
        $type = $_POST['type'];
        $limit = $_POST['limit'];
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
        $access_token = flex_idx_get_access_token();
        $param_url = [];
        $order = null;
        $view = '';
        $page = '1';
        $listing_type = '';
        $sale_type = [];
        if (!empty($type)) {

            if ($type == 'exclusive-listing') {
                $endpointFilter = FLEX_IDX_API_MARKET_EXCLUSIVE_LISTINGS;
                $listing_type = '2';
            } elseif ($type == 'recent-sale') {
                $endpointFilter = FLEX_IDX_API_MARKET_RECENT_SALE;
                $listing_type = '1';
            }

            $sendParams = array(
                'filter_id' => '',
                'listing_type' => $listing_type,
                'list_type' => $list_type,
                'limit' => $limit,
                'order' => $order,
                'sale_type' => $sale_type,
                'view' => $view,
                'page' => $page,
                'idx' => $param_url,
                'access_token' => $access_token,
                'version_endpoint' => 'new',
                'flex_credentials' => $flex_lead_credentials
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpointFilter);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
            $server_output = curl_exec($ch);
            $response_data = json_decode($server_output, true);
            $response['type'] = $type;
            $response['data'] = $response_data;
            curl_close($ch);
        }

        wp_send_json($response);
        exit;
    }
}

function flex_idx_filter_page_xhr_fn()
{
    $params = isset($_POST['idx']) ? $_POST['idx'] : array();
    $filter_ID = isset($_POST['filter_ID']) ? (int)$_POST['filter_ID'] : 0;
    $filter_type = isset($_POST['filter_type']) ? (int)$_POST['filter_type'] : 0;
    if (!empty($_POST['limit'])) $limit = $_POST['limit'];
    else     $limit = 'default';
    $access_token = flex_idx_get_access_token();
    $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';
    $flex_credentials_exp = explode('|', $flex_lead_credentials);
    $ip_address = get_client_ip_server();
    $referer = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
    $origin = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';
    $filter_token_ID = get_post_meta($filter_ID, '_flex_filter_page_id', true);
    $filter_listing_type = get_post_meta($filter_ID, '_flex_filter_page_fl', true);
    if (empty($filter_token_ID)) {
        $filter_token_ID = $_POST['filter_panel'];
    }
    if (isset($_POST['filter_panel_type'])) {
        $enpoint = FLEX_IDX_API_TRACK_PROPERTY_AGENT_OR_OFFICE;
        $filter_listing_type = $_POST['filter_panel_type_a'];
    } else {
        $enpoint = FLEX_IDX_API_MARKET;
    }
    if ('' != $filter_token_ID) {
        $filter_listing_type = 0;
    }
    if (empty($filter_listing_type) || $filter_listing_type == false) {
        $filter_listing_type = $filter_type;
    }
    $sendParams = array(
        'idx' => $params,
        'access_token' => $access_token,
        'flex_credentials' => $flex_lead_credentials,
        'version_endpoint' => 'new',
        'data' => array(
            'ip_address' => $ip_address,
            'url_referer' => $referer,
            'url_origin' => $origin,
            'user_agent' => $user_agent,
        ),
        'limit' => $limit,
        'filter_id' => $filter_token_ID,
        'listing_type' => $filter_listing_type,
        'page' => isset($params['page']) ? (int)$params['page'] : 1,
        'view' => isset($params['view']) ? $params['view'] : 'grid',
        'sort' => isset($params['sort']) ? $params['sort'] : 'price-desc',
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $enpoint);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
    $server_output = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($server_output, true);
    wp_send_json($response);
    exit;
}

if (!function_exists('flex_idx_autocomplete_xhr_fn')) {
    function flex_idx_autocomplete_xhr_fn()
    {
        $lookup = isset($_POST['lookup']) ? $_POST['lookup'] : '';
        $access_token = flex_idx_get_access_token();
        $sendParams = array(
            'lookup' => $lookup,
            'access_token' => $access_token,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_AUTOCOMPLETE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        wp_send_json($response);
        exit;
    }
}
if (!function_exists('flex_idx_register_assets')) {
    function flex_idx_register_assets()
    {
        global $flex_idx_lead, $flex_idx_info, $wpdb;
        $word_translate_setting = array('cancel' => __('Cancel', IDXBOOST_DOMAIN_THEME_LANG));

        $custom_strings = array(
            'type' => __('Type', IDXBOOST_DOMAIN_THEME_LANG),
            'city' => __('City', IDXBOOST_DOMAIN_THEME_LANG),
            'close' => __('Close', IDXBOOST_DOMAIN_THEME_LANG),
            'any_size' => __('Any Size', IDXBOOST_DOMAIN_THEME_LANG),
            'any_bed' => __('Any Bed', IDXBOOST_DOMAIN_THEME_LANG),
            'any_beds' => __('Any Bed(s)', IDXBOOST_DOMAIN_THEME_LANG),
            'any_bath' => __('Any Bath', IDXBOOST_DOMAIN_THEME_LANG),
            'any_baths' => __('Any Bath(s)', IDXBOOST_DOMAIN_THEME_LANG),
            'hello' => __('hello', IDXBOOST_DOMAIN_THEME_LANG),
            'bed' => __('Bed(s)', IDXBOOST_DOMAIN_THEME_LANG),
            'bath' => __('Bath(s)', IDXBOOST_DOMAIN_THEME_LANG),
            'sbeds' => __('Beds', IDXBOOST_DOMAIN_THEME_LANG),
            'sbaths' => __('Baths', IDXBOOST_DOMAIN_THEME_LANG),
            'beds' => __('Bed(s)', IDXBOOST_DOMAIN_THEME_LANG),
            'unit' => __('Unit', IDXBOOST_DOMAIN_THEME_LANG),
            'more_schools' => __('more schools', IDXBOOST_DOMAIN_THEME_LANG),
            'days_on_market' => __('Days on Market', IDXBOOST_DOMAIN_THEME_LANG),
            'sold_date' => __('Sold Date', IDXBOOST_DOMAIN_THEME_LANG),
            'sold_price' => __('Sold Price', IDXBOOST_DOMAIN_THEME_LANG),
            'living_size' => __('Living Size', IDXBOOST_DOMAIN_THEME_LANG),
            'asking_price' => __('Asking price', IDXBOOST_DOMAIN_THEME_LANG),
            'price' => __('Price', IDXBOOST_DOMAIN_THEME_LANG),
            'view' => __('View', IDXBOOST_DOMAIN_THEME_LANG),
            'listings' => __('Listings', IDXBOOST_DOMAIN_THEME_LANG),
            'saved_on' => __('Saved on', IDXBOOST_DOMAIN_THEME_LANG),
            'thank_you' => __('Thank you', IDXBOOST_DOMAIN_THEME_LANG),
            'baths' => __('Bath(s)', IDXBOOST_DOMAIN_THEME_LANG),
            'your_info_has_been_saved' => __('Your info has been saved', IDXBOOST_DOMAIN_THEME_LANG),
            'enter_you_new_password' => __('Enter you new Password', IDXBOOST_DOMAIN_THEME_LANG),
            'invalid_email_address' => __('invalid email address', IDXBOOST_DOMAIN_THEME_LANG),
            'please_fill_the_fields' => __('Please fill the fields', IDXBOOST_DOMAIN_THEME_LANG),
            'show' => __('Show %d to %d of %s results', IDXBOOST_DOMAIN_THEME_LANG),
            'reset_password' => __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG),
            'invalid_credentials_try_again' => __('Invalid credentials, try again.', IDXBOOST_DOMAIN_THEME_LANG),
            'logged_in_succesfully' => __('Logged in succesfully.', IDXBOOST_DOMAIN_THEME_LANG),
            'your_account_has_been_created_successfully' => __('Your account has been created successfully.', IDXBOOST_DOMAIN_THEME_LANG),
            'the_user_already_exists_try_another_email_address' => __('The user already exists, try another email address.', IDXBOOST_DOMAIN_THEME_LANG),
            'rented' => __('rented', IDXBOOST_DOMAIN_THEME_LANG),
            'save_favorite' => __('save favorite', IDXBOOST_DOMAIN_THEME_LANG),
            'register_for_details' => __('Register for details', IDXBOOST_DOMAIN_THEME_LANG),
            'remove_favorite' => __('remove favorite', IDXBOOST_DOMAIN_THEME_LANG),
            'first_page' => __('First page', IDXBOOST_DOMAIN_THEME_LANG),
            'last_page' => __('Last page', IDXBOOST_DOMAIN_THEME_LANG),
            'showing' => __('Showing', IDXBOOST_DOMAIN_THEME_LANG),
            'page' => __('Page', IDXBOOST_DOMAIN_THEME_LANG),
            'edit' => __('Edit', IDXBOOST_DOMAIN_THEME_LANG),
            'remove' => __('Remove', IDXBOOST_DOMAIN_THEME_LANG),
            'email_sent' => __('Email Sent!', IDXBOOST_DOMAIN_THEME_LANG),
            'your_email_was_sent_succesfully' => __('Your email was sent succesfully', IDXBOOST_DOMAIN_THEME_LANG),
            'to' => __('to', IDXBOOST_DOMAIN_THEME_LANG),
            'of' => __('of', IDXBOOST_DOMAIN_THEME_LANG),
            'pag' => __('pag', IDXBOOST_DOMAIN_THEME_LANG),
            'homes' => __('Homes', IDXBOOST_DOMAIN_THEME_LANG),
            'similar_properties_for_rent' => __('Similar Properties For Rent', IDXBOOST_DOMAIN_THEME_LANG),
            'Similar_properties_for_sale' => __('Similar Properties For Sale', IDXBOOST_DOMAIN_THEME_LANG),
            'condos_for_sale' => __('Condos For Sale', IDXBOOST_DOMAIN_THEME_LANG),
            'apartments_for_rent' => __('Apartments For Rent', IDXBOOST_DOMAIN_THEME_LANG),
            'condos_pending' => __('Condos Pending', IDXBOOST_DOMAIN_THEME_LANG),
            'condos_sold' => __('Condos Sold', IDXBOOST_DOMAIN_THEME_LANG),
            'all_neighborhoods' => __('All Neighborhoods', IDXBOOST_DOMAIN_THEME_LANG),
            'by_Name' => __('by Name', IDXBOOST_DOMAIN_THEME_LANG),
            'show_more' => __('show more', IDXBOOST_DOMAIN_THEME_LANG),
            'todays_prices' => __("Today's Prices", IDXBOOST_DOMAIN_THEME_LANG),
            'month' => __("month", IDXBOOST_DOMAIN_THEME_LANG),
            'searching' => __('Searching', IDXBOOST_DOMAIN_THEME_LANG),
            'condominiums' => __('Condominiums', IDXBOOST_DOMAIN_THEME_LANG),

            'sold_at' => __('Sold at', IDXBOOST_DOMAIN_THEME_LANG),
            'for_sale_at' => __('For Sale at', IDXBOOST_DOMAIN_THEME_LANG),
            'pending_at' => __('Pending at', IDXBOOST_DOMAIN_THEME_LANG),
            'for_rent_at' => __('For Rent at', IDXBOOST_DOMAIN_THEME_LANG),

            'marsh' => __('Marsh', IDXBOOST_DOMAIN_THEME_LANG),
            'pond' => __('Pond', IDXBOOST_DOMAIN_THEME_LANG),
            'condominium' => __('Condominium', IDXBOOST_DOMAIN_THEME_LANG),
            'adult_congregate' => __('Adult Congregate', IDXBOOST_DOMAIN_THEME_LANG),
            'agricultural' => __('Agricultural', IDXBOOST_DOMAIN_THEME_LANG),
            'apartments' => __('Apartments', IDXBOOST_DOMAIN_THEME_LANG),
            'automotive' => __('Automotive', IDXBOOST_DOMAIN_THEME_LANG),
            "building" => __('Building', IDXBOOST_DOMAIN_THEME_LANG),
            "business" => __('Business', IDXBOOST_DOMAIN_THEME_LANG),
            "church" => __('Church', IDXBOOST_DOMAIN_THEME_LANG),
            "commercial" => __('Commercial', IDXBOOST_DOMAIN_THEME_LANG),
            "commercial_business_agricultural_industrial_land" => __("Commercial / Business / Agricultural / Industrial Land", IDXBOOST_DOMAIN_THEME_LANG),
            "dock" => __('Dock', IDXBOOST_DOMAIN_THEME_LANG),
            "dock_height" => __('Dock Height', IDXBOOST_DOMAIN_THEME_LANG),
            "duplex_quad_plex_triplex" => __('Duplex / Quad Plex / Triplex', IDXBOOST_DOMAIN_THEME_LANG),
            "franchise" => __('Franchise', IDXBOOST_DOMAIN_THEME_LANG),
            "free_standing" => __('Free Standing', IDXBOOST_DOMAIN_THEME_LANG),
            "hotel" => __('Hotel', IDXBOOST_DOMAIN_THEME_LANG),
            "income" => __('Income', IDXBOOST_DOMAIN_THEME_LANG),
            "industrial" => __('Industrial', IDXBOOST_DOMAIN_THEME_LANG),
            "manufacturing" => __('Manufacturing', IDXBOOST_DOMAIN_THEME_LANG),
            "medical" => __('Medical', IDXBOOST_DOMAIN_THEME_LANG),
            "multifamily" => __('Multifamily', IDXBOOST_DOMAIN_THEME_LANG),
            "office" => __('Office', IDXBOOST_DOMAIN_THEME_LANG),
            "professional" => __('Professional', IDXBOOST_DOMAIN_THEME_LANG),
            "residential_income" => __('Residential Income', IDXBOOST_DOMAIN_THEME_LANG),
            "residential_Land_boat_docks" => __('Residential Land/Boat Docks', IDXBOOST_DOMAIN_THEME_LANG),
            "restaurant" => __('Restaurant', IDXBOOST_DOMAIN_THEME_LANG),
            "retail" => __('Retail', IDXBOOST_DOMAIN_THEME_LANG),
            "school" => __('School', IDXBOOST_DOMAIN_THEME_LANG),
            "service" => __('Service', IDXBOOST_DOMAIN_THEME_LANG),
            "shopping_center" => __('Shopping Center', IDXBOOST_DOMAIN_THEME_LANG),
            "showroom" => __('Showroom', IDXBOOST_DOMAIN_THEME_LANG),
            "special" => __('Special', IDXBOOST_DOMAIN_THEME_LANG),
            "store" => __('Store', IDXBOOST_DOMAIN_THEME_LANG),
            "warehouse" => __('Warehouse', IDXBOOST_DOMAIN_THEME_LANG),
            "housing_older_persons" => __('Housing Older Persons', IDXBOOST_DOMAIN_THEME_LANG),
            "occupied" => __('Occupied', IDXBOOST_DOMAIN_THEME_LANG),
            "vacant" => __('Vacant', IDXBOOST_DOMAIN_THEME_LANG),

            'townhouses' => __('Townhouses', IDXBOOST_DOMAIN_THEME_LANG),
            'multi_family' => __('Multi-Family', IDXBOOST_DOMAIN_THEME_LANG),
            'vacant_land' => __('Vacant Land', IDXBOOST_DOMAIN_THEME_LANG),
            'single_family_homes' => __('Single Family Homes', IDXBOOST_DOMAIN_THEME_LANG),
            'river_front' => __('River Front', IDXBOOST_DOMAIN_THEME_LANG),
            'point_lot' => __('Point Lot', IDXBOOST_DOMAIN_THEME_LANG),
            'ocean_front' => __('Ocean Front', IDXBOOST_DOMAIN_THEME_LANG),
            'bay_front' => __('Bay Front', IDXBOOST_DOMAIN_THEME_LANG),
            'bay_front' => __('Bay', IDXBOOST_DOMAIN_THEME_LANG),
            'canal' => __('Canal', IDXBOOST_DOMAIN_THEME_LANG),
            'fixed_bridge' => __('Fixed Bridge', IDXBOOST_DOMAIN_THEME_LANG),
            'intracoastal' => __('Intracoastal', IDXBOOST_DOMAIN_THEME_LANG),

            'garden' => __('Garden', IDXBOOST_DOMAIN_THEME_LANG),
            'ocean' => __('Ocean', IDXBOOST_DOMAIN_THEME_LANG),
            'City' => __('city', IDXBOOST_DOMAIN_THEME_LANG),
            'lagoon' => __('Lagoon', IDXBOOST_DOMAIN_THEME_LANG),
            'river' => __('River', IDXBOOST_DOMAIN_THEME_LANG),
            'strip_view' => __('Strip View', IDXBOOST_DOMAIN_THEME_LANG),
            'mountain' => __('Mountain', IDXBOOST_DOMAIN_THEME_LANG),
            'park_greenbelt' => __('Park Greenbelt', IDXBOOST_DOMAIN_THEME_LANG),
            'court_yard' => __('Court yard', IDXBOOST_DOMAIN_THEME_LANG),
            'golf' => __('Golf', IDXBOOST_DOMAIN_THEME_LANG),
            'lake' => __('Lake', IDXBOOST_DOMAIN_THEME_LANG),

            'bay' => __('Bay', IDXBOOST_DOMAIN_THEME_LANG),
            'gulf' => __('Gulf', IDXBOOST_DOMAIN_THEME_LANG),
            'creek' => __('Creek', IDXBOOST_DOMAIN_THEME_LANG),
            'mangrove' => __('Mangrove', IDXBOOST_DOMAIN_THEME_LANG),
            'navigable' => __('Navigable', IDXBOOST_DOMAIN_THEME_LANG),
            'river_frontage' => __('River Frontage', IDXBOOST_DOMAIN_THEME_LANG),
            'basin' => __('Basin', IDXBOOST_DOMAIN_THEME_LANG),
            'seawall' => __('Seawall', IDXBOOST_DOMAIN_THEME_LANG),


            'lake_front' => __('Lake Front', IDXBOOST_DOMAIN_THEME_LANG),
            'equestrian' => __('Equestrian', IDXBOOST_DOMAIN_THEME_LANG),
            'pets' => __('Pets', IDXBOOST_DOMAIN_THEME_LANG),
            'pool' => __('Pool', IDXBOOST_DOMAIN_THEME_LANG),
            'water_front' => __('Waterfront', IDXBOOST_DOMAIN_THEME_LANG),
            'water_access' => __('Water Access', IDXBOOST_DOMAIN_THEME_LANG),
            'water' => __('Water', IDXBOOST_DOMAIN_THEME_LANG),
            // 'open_house' => __('Open House', IDXBOOST_DOMAIN_THEME_LANG),
            'penthouse' => __('Penthouse', IDXBOOST_DOMAIN_THEME_LANG),
            'lofts' => __('Lofts', IDXBOOST_DOMAIN_THEME_LANG),
            'gated_community' => __('Gated Community', IDXBOOST_DOMAIN_THEME_LANG),
            'tennis_courts' => __('Tennis Courts', IDXBOOST_DOMAIN_THEME_LANG),
            'tennis_court' => __('Tennis Court', IDXBOOST_DOMAIN_THEME_LANG),
            'golf_course' => __('Golf Course', IDXBOOST_DOMAIN_THEME_LANG),
            'swimming_pool' => __('Swimming Pool', IDXBOOST_DOMAIN_THEME_LANG),
            'furnished' => __('Furnished', IDXBOOST_DOMAIN_THEME_LANG),
            'ocean_access' => __('Ocean Access', IDXBOOST_DOMAIN_THEME_LANG),
            'homes_condominiums_townhouses' => __('Homes, Condominiums, Townhouses', IDXBOOST_DOMAIN_THEME_LANG),
            'homes_condominiums' => __('Homes, Condominiums', IDXBOOST_DOMAIN_THEME_LANG),
            'condominiums_townhouses' => __('Condominiums, Townhouses', IDXBOOST_DOMAIN_THEME_LANG),
            'next_page' => __('Next page', IDXBOOST_DOMAIN_THEME_LANG),
            'previous_page' => __('Previous Page', IDXBOOST_DOMAIN_THEME_LANG),
            'your_message_has_been_sent' => __('Your message has been sent!', IDXBOOST_DOMAIN_THEME_LANG),
            'price_range' => __('Price range', IDXBOOST_DOMAIN_THEME_LANG),
            'average_listing_price' => __('Average Listing Price', IDXBOOST_DOMAIN_THEME_LANG),
            'average_rental_price' => __('Average Rental Price', IDXBOOST_DOMAIN_THEME_LANG),
            'average_sold_price' => __('Average Sold Price', IDXBOOST_DOMAIN_THEME_LANG),
            'average_pending_price' => __('Average Pending Price', IDXBOOST_DOMAIN_THEME_LANG),
            'from' => __('from', IDXBOOST_DOMAIN_THEME_LANG),
            'properties' => __('Properties', IDXBOOST_DOMAIN_THEME_LANG),
            'loading_properties' => __('Loading Properties...', IDXBOOST_DOMAIN_THEME_LANG),
            'and' => __('and', IDXBOOST_DOMAIN_THEME_LANG),
            'in' => __('in', IDXBOOST_DOMAIN_THEME_LANG),
            'new_listing' => __('new listing', IDXBOOST_DOMAIN_THEME_LANG),
            'active_under_contract' => __('Active Under Contract', IDXBOOST_DOMAIN_THEME_LANG),
            'pending' => __('pending', IDXBOOST_DOMAIN_THEME_LANG),
            'boat_dock' => __('Boat Dock', IDXBOOST_DOMAIN_THEME_LANG),
            'short_sales' => __('Short Sales', IDXBOOST_DOMAIN_THEME_LANG),
            'foreclosures' => __('Foreclosures', IDXBOOST_DOMAIN_THEME_LANG),
            'any' => __('Any', IDXBOOST_DOMAIN_THEME_LANG),
            'any_price' => __('Any Price', IDXBOOST_DOMAIN_THEME_LANG),
            'any_price_max' => __('Any Price', IDXBOOST_DOMAIN_THEME_LANG),
            'any_type' => __('Any Type', IDXBOOST_DOMAIN_THEME_LANG),
            'up_to' => __('up to', IDXBOOST_DOMAIN_THEME_LANG),
            'details' => __('View detail', IDXBOOST_DOMAIN_THEME_LANG),
            'for_sale' => __('For Sale', IDXBOOST_DOMAIN_THEME_LANG),
            'for_rent' => __('For Rent', IDXBOOST_DOMAIN_THEME_LANG),
            'for_sold' => __('For Sold', IDXBOOST_DOMAIN_THEME_LANG),

            'condos_for_sale' => __('Condos For Sale', IDXBOOST_DOMAIN_THEME_LANG),
            'condos_for_rent' => __('Condos For Rent', IDXBOOST_DOMAIN_THEME_LANG),
            'condos_sold' => __('Condos Sold', IDXBOOST_DOMAIN_THEME_LANG),
            'condos_pending' => __('Condos Pending', IDXBOOST_DOMAIN_THEME_LANG),
            'save' => __('Save', IDXBOOST_DOMAIN_THEME_LANG),
            'sold' => __('Sold', IDXBOOST_DOMAIN_THEME_LANG),
            'bname' => __('Building Name', IDXBOOST_DOMAIN_THEME_LANG),
            'price_range' => __('Price Range', IDXBOOST_DOMAIN_THEME_LANG),
            'bedrooms_units' => __('Bedrooms Units', IDXBOOST_DOMAIN_THEME_LANG),
            'bedroom_condos' => __('Bedroom Condos', IDXBOOST_DOMAIN_THEME_LANG),
            'bedroom_apartments' => __('Bedroom Apartments', IDXBOOST_DOMAIN_THEME_LANG),
            'bedrooms' => __('Bedrooms', IDXBOOST_DOMAIN_THEME_LANG),
            'units' => __('Units', IDXBOOST_DOMAIN_THEME_LANG),
            'floors' => __('Floors', IDXBOOST_DOMAIN_THEME_LANG),
            'address' => __('Address', IDXBOOST_DOMAIN_THEME_LANG),
            'sqft' => __('Sq.Ft.', IDXBOOST_DOMAIN_THEME_LANG),
            'check_your_mailbox' => __('Check your mailbox', IDXBOOST_DOMAIN_THEME_LANG),
            'password_change' => __('Password Change', IDXBOOST_DOMAIN_THEME_LANG),
            'deleted' => __('Deleted!', IDXBOOST_DOMAIN_THEME_LANG),
            'delete' => __('Delete', IDXBOOST_DOMAIN_THEME_LANG),
            'yes_delete_it' => __('Yes, delete it!', IDXBOOST_DOMAIN_THEME_LANG),
            'newconstruction' => __('New Construction', IDXBOOST_DOMAIN_THEME_LANG),
            'preconstruction' => __('Preconstruction', IDXBOOST_DOMAIN_THEME_LANG),
            'neighborhood' => __('Neighborhood', IDXBOOST_DOMAIN_THEME_LANG),
            'good_job' => __('Good job!', IDXBOOST_DOMAIN_THEME_LANG),
            'congratulations' => __('Congratulations', IDXBOOST_DOMAIN_THEME_LANG),
            'cancel' => __('Cancel', IDXBOOST_DOMAIN_THEME_LANG),
            'search_saved' => __('Search Saved!', IDXBOOST_DOMAIN_THEME_LANG),
            'draw_your_map' => __('DRAW YOUR MAP', IDXBOOST_DOMAIN_THEME_LANG),
            'current_value_must_be_less_than_or_equal_to' => __('current value must be less than or equal to', IDXBOOST_DOMAIN_THEME_LANG),
            'are_you_sure_you_want_to_remove_this_property' => __("Are you sure you want to remove this property?", IDXBOOST_DOMAIN_THEME_LANG),
            'your_search_has_been_saved_successfuly' => __('Your search has been saved successfuly', IDXBOOST_DOMAIN_THEME_LANG),
            'you_cannot_save_search_with_more_than_500_properties' => __('You cannot save a search with more than 500 properties.', IDXBOOST_DOMAIN_THEME_LANG),
            'youmust_selectat_least_one_checkbox_from_below' => __('You must select at least one checkbox from below.', IDXBOOST_DOMAIN_THEME_LANG),
            'yoursearch_has_been_saved_successfully' => __('Your search has been saved successfully.', IDXBOOST_DOMAIN_THEME_LANG),
            'you_must_provide_a_name_for_this_search' => __('You must provide a name for this search.', IDXBOOST_DOMAIN_THEME_LANG),
            'the_saved_search_has_been_removed_from_your_alerts' => __('The saved search has been removed from your alerts', IDXBOOST_DOMAIN_THEME_LANG),
            'are_you_sure' => __('Are you sure?', IDXBOOST_DOMAIN_THEME_LANG),
            'the_building_has_been_removed_from_your_favorites' => __('The building has been removed from your favorites.', IDXBOOST_DOMAIN_THEME_LANG),
            'are_you_sure_you_want_to_remove_this_building' => __('Are you sure you want to remove this building?', IDXBOOST_DOMAIN_THEME_LANG),
            'the_property_has_been_removed_from_your_favorites' => __('The property has been removed from your favorites.', IDXBOOST_DOMAIN_THEME_LANG),
            'are_you_sure_you_want_to_remove_this_saved_search' => __('Are you sure you want to remove this saved search?', IDXBOOST_DOMAIN_THEME_LANG),
            'please_wait_youraccount_is_being_created' => __('Please wait your account is being created...', IDXBOOST_DOMAIN_THEME_LANG),
            'your_account_is_being_created' => __('Your account is being created', IDXBOOST_DOMAIN_THEME_LANG),
            'this_might_take_a_while_do_not_reload_thepage' => __('This might take a while. Do not reload the page.', IDXBOOST_DOMAIN_THEME_LANG),
            'inq_details' => __('Inquire for details', IDXBOOST_DOMAIN_THEME_LANG),
            'welcome_back' => __('Welcome Back', IDXBOOST_DOMAIN_THEME_LANG),
            'welcome' => __('Welcome', IDXBOOST_DOMAIN_THEME_LANG),
            'sign_in_below' => __('Sign in below', IDXBOOST_DOMAIN_THEME_LANG),
            'oops' => __('Oops...', IDXBOOST_DOMAIN_THEME_LANG),
            'join_to_save_listings_and_receive_updates' => __('Join to save listings and receive updates', IDXBOOST_DOMAIN_THEME_LANG),
            'register' => __('Register', IDXBOOST_DOMAIN_THEME_LANG),
            'logout' => __('Logout', IDXBOOST_DOMAIN_THEME_LANG),
            'year' => __('Year', IDXBOOST_DOMAIN_THEME_LANG),
        );
        // main styles
        wp_register_style('flex-idx-main-project', FLEX_IDX_URI . 'css/main.css', array(), iboost_get_mod_time("css/main.css"));
        // buildings
        wp_register_style('flex-idx-buildings', FLEX_IDX_URI . 'css/flex-idx-buildings.css', array(), iboost_get_mod_time("css/flex-idx-buildings.css"));
        wp_register_script('flex-idx-buildings-js', FLEX_IDX_URI . 'js/flex-idx-buildings.js', array('jquery'), iboost_get_mod_time("js/flex-idx-buildings.js"));
        // buyers and sellers
        wp_register_script(
            "iboost-buyers-sellers-js",
            FLEX_IDX_URI . "js/buyers-and-sellers.js",
            array("jquery", "google-maps-api"),
            iboost_get_mod_time("js/buyers-and-sellers.js")
        );
        // sweetalert
        wp_enqueue_style('sweetalert-css', FLEX_IDX_URI . 'css/sweetalert.css', array(), iboost_get_mod_time("css/sweetalert.css"));
        wp_enqueue_script('sweetalert-js', FLEX_IDX_URI . 'js/sweetalert.min.js', array(), iboost_get_mod_time("js/sweetalert.min.js"), true);
        wp_localize_script('sweetalert-js', 'idx_translate_setting', $word_translate_setting);


        // underscore
        // wp_register_script('underscore', FLEX_IDX_URI . 'vendor/underscore/underscore.js', array());
        wp_register_script('underscore-mixins', FLEX_IDX_URI . 'js/underscore.mixins.js', array('underscore'), iboost_get_mod_time("js/underscore.mixins.js"));
        // mortgage calculator
        wp_register_script('flex-idx-property-js-only', FLEX_IDX_URI . 'js/property-calculater.js', array('jquery'), iboost_get_mod_time("js/property-calculater.js"));
        // cookies manager
        wp_register_script('flex-cookies-manager', FLEX_IDX_URI . 'js/js.cookie.min.js', array(), iboost_get_mod_time("js/js.cookie.min.js"), true);
        // pusher
        wp_register_script('flex-pusher-js', '//js.pusher.com/4.1/pusher.min.js', array(), false, true);
        // auth check
        wp_register_script('flex-auth-check', FLEX_IDX_URI . 'js/flex-auth-check.js', array(
            'flex-pusher-js',
            'flex-cookies-manager',
            'jquery',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch'
        ), iboost_get_mod_time("js/flex-auth-check.js"), true);
        wp_enqueue_script('flex-auth-check');
        // mini search
        wp_register_script('flex-mini-search', FLEX_IDX_URI . 'js/idx-mini-search.js', array('jquery', 'underscore', 'flex-auth-check'), iboost_get_mod_time("js/idx-mini-search.js"));
        wp_register_script('idx-mini-search-new', FLEX_IDX_URI . 'js/idx-mini-search-new.js', array('jquery', 'underscore', 'flex-auth-check'), iboost_get_mod_time("js/idx-mini-search-new.js"));

        // handlebars
        wp_register_script('handlebars', FLEX_IDX_URI . 'js/handlebars-v4.1.2.js', array(), iboost_get_mod_time("js/handlebars-v4.1.2.js"));
        // flex idx search filter
        // wp_register_style('flex-idx-search-filter-fonts', 'https://file.myfontastic.com/SYf8h6NoBXoNYppF4gDLt/icons.css');
        // wp_register_style("flex-idx-search-filter-map-css", FLEX_IDX_URI . "css/flex-idx-search-filter-map.css");
        // wp_register_style('flex-idx-search-filter-css', FLEX_IDX_URI . 'css/flex-idx-search-filter.css', array(
        //     // 'flex-idx-search-filter-fonts',
        //     "flex-idx-search-filter-map-css"
        // ));
        wp_register_script('flex-idx-search-filter-slider', FLEX_IDX_URI . 'js/greatslider.jquery.min.js', array(
            'jquery'
        ), iboost_get_mod_time("js/greatslider.jquery.min.js"));

        // wp_register_script('flex-idx-search-filter-slideritems', FLEX_IDX_URI . 'js/flex-idx-search-filter-slideritems.js', array(
        //     'jquery',
        //     'flex-idx-filter-jquery-ui-touch',
        //     'flex-idx-search-filter-slider',
        //     'underscore',
        //     'handlebars',
        //     'google-maps-api',
        //     'google-maps-utility-library-richmarker',
        //     'google-maps-utility-library-infobubble'
        // ), iboost_get_mod_time("js/flex-idx-search-filter-slideritems.js"));

        wp_register_script('flex-idx-search-filter', FLEX_IDX_URI . 'js/flex-idx-search-filter.js', array(
            'jquery',
            'flex-idx-filter-jquery-ui-touch',
            'flex-idx-search-filter-slider',
            'underscore',
            'handlebars',
            'google-maps-api',
            'google-maps-utility-library-richmarker',
            'google-maps-utility-library-infobubble',
            'flex-lazyload-plugin'
        ), iboost_get_mod_time("js/flex-idx-search-filter.js"));

        wp_register_script('flex-idx-search-commercial-filter', FLEX_IDX_URI . 'js/flex-idx-search-commercial-filter.js', array(
            'jquery',
            'flex-idx-filter-jquery-ui-touch',
            'flex-idx-search-filter-slider',
            'underscore',
            'handlebars',
            'google-maps-api',
            'google-maps-utility-library-richmarker',
            'google-maps-utility-library-infobubble'
        ), iboost_get_mod_time("js/flex-idx-search-commercial-filter.js"));

        wp_register_script('flex-idx-search-commercial-v2', FLEX_IDX_URI . 'js/flex-idx-search-commercial-v2.js', array(
            'jquery',
            'flex-idx-filter-jquery-ui-touch',
            'flex-idx-search-filter-slider',
            'underscore',
            'handlebars',
            'google-maps-api',
            'google-maps-utility-library-richmarker',
            'google-maps-utility-library-infobubble'
        ), iboost_get_mod_time("js/flex-idx-search-commercial-v2.js"));

        wp_localize_script('flex-idx-search-commercial-v2', '__flex_idx_search_filter_v2', array(
            'commercial_types' => $flex_idx_info['commercial_types'],
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'agentFullName' => $flex_idx_info["agent"]["agent_first_name"] . " " . $flex_idx_info["agent"]["agent_last_name"],
            'agentPhoto' => $flex_idx_info["agent"]["agent_contact_photo_profile"],
            'agentPhone' => $flex_idx_info["agent"]["agent_contact_phone_number"],
            'lookupSearchFilter' => FLEX_IDX_API_COMMERCIAL_SEARCH_V2_LOOKUP,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'trackListingsDetail' => FLEX_IDX_API_SEARCH_TRACK,
            'saveListings' => FLEX_IDX_API_SEARCH_FILTER_SAVE,
            'shareWithFriendEndpoint' => FLEX_IDX_API_SHARE_PROPERTY,
            'requestInformationEndpoint' => FLEX_IDX_API_REQUEST_INFO_PROPERTY,
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'lookupAutocomplete' => FLEX_IDX_SERVICE_SUGGESTIONS,
            'accessToken' => flex_idx_get_access_token(),
            'boardId' => $flex_idx_info['board_id'],
            'search' => $flex_idx_info['search'],
            'fields' => 'address,building,city,street,subdivision,zip,neighborhood',
            'searchFilterPermalink' => get_permalink(),
            'leadFirstName' => (!empty($flex_idx_lead["lead_info"]["first_name"])) ? $flex_idx_lead["lead_info"]["first_name"] : "",
            'leadLastName' => (!empty($flex_idx_lead["lead_info"]["last_name"])) ? $flex_idx_lead["lead_info"]["last_name"] : "",
            'leadEmailAddress' => (!empty($flex_idx_lead["lead_info"]["email_address"])) ? $flex_idx_lead["lead_info"]["email_address"] : "",
            'leadPhoneNumber' => (!empty($flex_idx_lead["lead_info"]["phone_number"])) ? $flex_idx_lead["lead_info"]["phone_number"] : ""
        ));

        wp_register_script('flex-idx-search-filter-v2', FLEX_IDX_URI . 'js/flex-idx-search-filter-v2.js', array(
            'jquery',
            'flex-idx-filter-jquery-ui-touch',
            'flex-idx-search-filter-slider',
            'underscore',
            'handlebars',
            'google-maps-api',
            'google-maps-utility-library-richmarker',
            'google-maps-utility-library-infobubble'
        ), iboost_get_mod_time("js/flex-idx-search-filter-v2.js"));

        wp_localize_script('flex-idx-search-filter', '__flex_idx_search_filter', array(
            "updateEventUri" => IDX_BOOST_TRACK_COLLECTION_VIEWS,
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'hackbox' => $flex_idx_info["agent"]["hackbox"],
            'list_offmarket' => '',
            'agentFullName' => $flex_idx_info["agent"]["agent_first_name"] . " " . $flex_idx_info["agent"]["agent_last_name"],
            'agentPhoto' => $flex_idx_info["agent"]["agent_contact_photo_profile"],
            'agentPhone' => $flex_idx_info["agent"]["agent_contact_phone_number"],
            'lookupSearchFilter' => FLEX_IDX_API_SEARCH_FILTER,
            'lookupSearchCommercialFilter' => FLEX_IDX_API_SEARCH_COMMERCIAL_FILTER,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'trackListingsDetail' => FLEX_IDX_API_SEARCH_TRACK,
            'saveListings' => FLEX_IDX_API_SEARCH_FILTER_SAVE,
            'shareWithFriendEndpoint' => FLEX_IDX_API_SHARE_PROPERTY,
            'requestInformationEndpoint' => FLEX_IDX_API_REQUEST_INFO_PROPERTY,
            'requestDataOffmarket' => FLEX_IDX_API_REQUEST_GET_OFF_MARKET_LISTING,
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'lookupAutocomplete' => FLEX_IDX_SERVICE_SUGGESTIONS,
            'accessToken' => flex_idx_get_access_token(),
            'boardId' => $flex_idx_info['board_id'],
            'search' => $flex_idx_info['search'],
            'fields' => 'address,building,city,street,subdivision,zip,neighborhood',
            'searchFilterPermalink' => get_permalink(),
            'leadFirstName' => (!empty($flex_idx_lead["lead_info"]["first_name"])) ? $flex_idx_lead["lead_info"]["first_name"] : "",
            'leadLastName' => (!empty($flex_idx_lead["lead_info"]["last_name"])) ? $flex_idx_lead["lead_info"]["last_name"] : "",
            'leadEmailAddress' => (!empty($flex_idx_lead["lead_info"]["email_address"])) ? $flex_idx_lead["lead_info"]["email_address"] : "",
            'leadPhoneNumber' => (!empty($flex_idx_lead["lead_info"]["phone_number"])) ? $flex_idx_lead["lead_info"]["phone_number"] : ""
        ));

        wp_localize_script('flex-idx-search-commercial-filter', '__flex_idx_search_filter', array(
            'commercial_types' => $flex_idx_info['commercial_types'],
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'hackbox' => $flex_idx_info["agent"]["hackbox"],
            'list_offmarket' => '',
            'agentFullName' => $flex_idx_info["agent"]["agent_first_name"] . " " . $flex_idx_info["agent"]["agent_last_name"],
            'agentPhoto' => $flex_idx_info["agent"]["agent_contact_photo_profile"],
            'agentPhone' => $flex_idx_info["agent"]["agent_contact_phone_number"],
            'lookupSearchFilter' => FLEX_IDX_API_SEARCH_FILTER,
            'lookupSearchCommercialFilter' => FLEX_IDX_API_SEARCH_COMMERCIAL_FILTER,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'trackListingsDetail' => FLEX_IDX_API_SEARCH_TRACK,
            'saveListings' => FLEX_IDX_API_SEARCH_FILTER_SAVE,
            'shareWithFriendEndpoint' => FLEX_IDX_API_SHARE_PROPERTY,
            'requestInformationEndpoint' => FLEX_IDX_API_REQUEST_INFO_PROPERTY,
            'requestDataOffmarket' => FLEX_IDX_API_REQUEST_GET_OFF_MARKET_LISTING,
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'lookupAutocomplete' => FLEX_IDX_SERVICE_SUGGESTIONS,
            'accessToken' => flex_idx_get_access_token(),
            'boardId' => $flex_idx_info['board_id'],
            'search' => $flex_idx_info['search'],
            'fields' => 'address,building,city,street,subdivision,zip,neighborhood',
            'searchFilterPermalink' => get_permalink(),
            'leadFirstName' => (!empty($flex_idx_lead["lead_info"]["first_name"])) ? $flex_idx_lead["lead_info"]["first_name"] : "",
            'leadLastName' => (!empty($flex_idx_lead["lead_info"]["last_name"])) ? $flex_idx_lead["lead_info"]["last_name"] : "",
            'leadEmailAddress' => (!empty($flex_idx_lead["lead_info"]["email_address"])) ? $flex_idx_lead["lead_info"]["email_address"] : "",
            'leadPhoneNumber' => (!empty($flex_idx_lead["lead_info"]["phone_number"])) ? $flex_idx_lead["lead_info"]["phone_number"] : ""
        ));

        wp_localize_script('flex-idx-search-filter-v2', '__flex_idx_search_filter_v2', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'hackbox' => $flex_idx_info["agent"]["hackbox"],
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'agentFullName' => $flex_idx_info["agent"]["agent_first_name"] . " " . $flex_idx_info["agent"]["agent_last_name"],
            'agentPhoto' => $flex_idx_info["agent"]["agent_contact_photo_profile"],
            'agentPhone' => $flex_idx_info["agent"]["agent_contact_phone_number"],
            'lookupSearchFilter' => FLEX_IDX_API_SEARCH_V2_LOOKUP,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'trackListingsDetail' => FLEX_IDX_API_SEARCH_TRACK,
            'saveListings' => FLEX_IDX_API_SEARCH_FILTER_SAVE,
            'shareWithFriendEndpoint' => FLEX_IDX_API_SHARE_PROPERTY,
            'requestInformationEndpoint' => FLEX_IDX_API_REQUEST_INFO_PROPERTY,
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'lookupAutocomplete' => FLEX_IDX_SERVICE_SUGGESTIONS,
            'accessToken' => flex_idx_get_access_token(),
            'boardId' => $flex_idx_info['board_id'],
            'search' => $flex_idx_info['search'],
            'fields' => 'address,building,city,street,subdivision,zip,neighborhood',
            'searchFilterPermalink' => get_permalink(),
            'leadFirstName' => (!empty($flex_idx_lead["lead_info"]["first_name"])) ? $flex_idx_lead["lead_info"]["first_name"] : "",
            'leadLastName' => (!empty($flex_idx_lead["lead_info"]["last_name"])) ? $flex_idx_lead["lead_info"]["last_name"] : "",
            'leadEmailAddress' => (!empty($flex_idx_lead["lead_info"]["email_address"])) ? $flex_idx_lead["lead_info"]["email_address"] : "",
            'leadPhoneNumber' => (!empty($flex_idx_lead["lead_info"]["phone_number"])) ? $flex_idx_lead["lead_info"]["phone_number"] : ""
        ));

        // register for ib search box
        wp_register_script("ib-search-box", FLEX_IDX_URI . "js/ib-search-box.js", array("jquery"));
        // css for favorites
        wp_register_style('flex-favorites-css', FLEX_IDX_URI . 'css/jquery-ui-timepicker-addon.css');
        $translation_array = $custom_strings;
        wp_localize_script('flex-auth-check', 'word_translate', $translation_array);

        /*MAP STYLE IDXBOOST*/
        $tbl_idxboost_tools = $wpdb->prefix . 'idxboost_setting';
        $idxboost_setting_tools_map_style = $wpdb->get_col("SELECT idx_map_style FROM {$tbl_idxboost_tools}; ");
        $descr_tools_map_style = [];


        if (is_array($idxboost_setting_tools_map_style) && count($idxboost_setting_tools_map_style) > 0) {
            $descr_tools_map_style = $idxboost_setting_tools_map_style[0];
        }
        /*MAP STYLE IDXBOOST*/
        wp_localize_script('flex-auth-check', 'style_map_idxboost', $descr_tools_map_style);

        wp_localize_script('flex-auth-check', '__flex_g_settings', array(
            'events' => [
                'trackingServiceUrl' => IDX_BOOST_LEAD_TRACKING_EVENTS
            ],
            'fetchLeadActivitiesEndpoint' => FLEX_IDX_API_LEAD_FETCH_ACTIVITIES,
            'hideTooltipLeadEndpoint' => FLEX_IDX_API_LEAD_HIDE_TOOLTIP,
            'shareWithFriendEndpoint' => FLEX_IDX_API_SHARE_PROPERTY,
            'signup_left_clicks' => (isset($flex_idx_info["agent"]["signup_left_clicks"]) && !empty($flex_idx_info["agent"]["signup_left_clicks"]) ? (int)$flex_idx_info["agent"]["signup_left_clicks"] : null),
            'force_registration_forced' => (isset($flex_idx_info["agent"]["force_registration_forced"]) && ("1" == $flex_idx_info["agent"]["force_registration_forced"])) ? "yes" : "no",
            'has_facebook_login_enabled' => (isset($flex_idx_info["agent"]["facebook_login_enabled"]) && ("1" == $flex_idx_info["agent"]["facebook_login_enabled"])) ? "yes" : "no",
            'has_google_login_enabled' => (isset($flex_idx_info["agent"]["google_login_enabled"]) && ("1" == $flex_idx_info["agent"]["google_login_enabled"])) ? "yes" : "no",
            'checkLeadUsername' => FLEX_IDX_API_LEADS_CHECK_USERNAME,
            'accessToken' => flex_idx_get_access_token(),
            'boardId' => $flex_idx_info['board_id'],
            'is_mobile' => wp_is_mobile(),
            'socketAuthUrl' => FLEX_IDX_URI . 'socket-auth.php',
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'params' => $flex_idx_info['search'],
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'templateDirectoryUrl' => $flex_idx_info["template_directory_url"],
            'pusher' => array(
                'app_cluster' => $flex_idx_info['pusher']['pusher_app_cluster'],
                'app_key' => $flex_idx_info['pusher']['pusher_app_key'],
                'presence_channel' => $flex_idx_info['pusher']['pusher_presence_channel']
            ),
            'suggestions' => array('board' => $flex_idx_info['board_id'], 'service_url' => FLEX_IDX_SERVICE_SUGGESTIONS),
            'g_analytics_account' => $flex_idx_info["agent"]["google_analytics"],
            'g_adwords_account' => $flex_idx_info["agent"]["google_adwords"],
            'force_registration' => $flex_idx_info["agent"]["force_registration"],
            'page_setting' => $flex_idx_info['pages'],
            'user_show_quizz' => $flex_idx_info["agent"]["user_show_quizz"],
            'has_dynamic_ads' => isset($flex_idx_info['agent']['has_dynamic_ads']) ? (bool)$flex_idx_info['agent']['has_dynamic_ads'] : false,
            'has_seo_client' => isset($flex_idx_info['agent']['has_seo_client']) ? (bool)$flex_idx_info['agent']['has_seo_client'] : false,
            'google_recaptcha_public_key' => isset($flex_idx_info['agent']['google_captcha_public_key']) ? $flex_idx_info['agent']['google_captcha_public_key'] : "",
            'has_enterprise_recaptcha' => isset($flex_idx_info['agent']['has_enterprise_recaptcha']) ? (bool)$flex_idx_info['agent']['has_enterprise_recaptcha'] : false,
            'recaptcha_site_key' => isset($flex_idx_info['agent']['recaptcha_site_key']) ? $flex_idx_info['agent']['recaptcha_site_key'] : null,
            'recaptcha_api_key' => isset($flex_idx_info['agent']['recaptcha_api_key']) ? $flex_idx_info['agent']['recaptcha_api_key'] : null
        ));

        wp_register_script('google-maps-api', sprintf('//maps.googleapis.com/maps/api/js?libraries=drawing,geometry,places&key=%s', $flex_idx_info["agent"]["google_maps_api_key"]));
        wp_register_script('google-maps-utility-library-richmarker', FLEX_IDX_URI . 'js/richmarker-compiled.js', array('google-maps-api'), iboost_get_mod_time("js/richmarker-compiled.js"));
        wp_register_script('google-maps-utility-library-infobubble', FLEX_IDX_URI . 'js/infobubble-compiled.js', array('google-maps-api'), iboost_get_mod_time("js/infobubble-compiled.js"));
        // styles for infowindows [google maps]
        wp_register_style('flex-idx-css-map', FLEX_IDX_URI . 'css/infowindows.css', array(), iboost_get_mod_time("css/infowindows.css"));
        // property detail [start]
        wp_register_style('flex-idx-search-css', FLEX_IDX_URI . 'css/flex-search.css', array(), iboost_get_mod_time("css/flex-search.css"));
        wp_register_style('flex-main-css', FLEX_IDX_URI . 'css/main.css', array(), iboost_get_mod_time("css/main.css"));
        wp_register_script('flex-idx-property-js', FLEX_IDX_URI . 'js/properties-js.js', array(
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'google-maps-api',
            'flex-idx-master',
            'flex-idx-property-js-only',
        ), iboost_get_mod_time("js/properties-js.js"));
        // property detail [end]
        // flex autocomplete [start]
        wp_register_script('flex-idx-autocomplete', FLEX_IDX_URI . 'js/flex-idx-single-autocomplete.js', array(
            'jquery',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'underscore',
        ), iboost_get_mod_time("js/flex-idx-single-autocomplete.js"));
        // flex autocomplete [end]

        wp_register_style('flex-idx-single-property-collection-css', FLEX_IDX_URI . 'css/single-property.css', array(), iboost_get_mod_time("css/main.css"));

        /*wp_register_script('greatslider', FLEX_IDX_URI . 'js/greatslider.jquery.min.js', array('jquery'));
        wp_register_script('flex-idx-slider-main', FLEX_IDX_URI . 'js/greatslider-main.js', array('jquery'));
        wp_register_script('flex-idx-slider', FLEX_IDX_URI . 'js/greatslider-main.js', array('jquery', 'greatslider'));*/
        // filter pages [start]
        wp_register_script('flex-idx-filter-project-master-tem', FLEX_IDX_URI . 'js/dgt-project-master.js', array('jquery'), iboost_get_mod_time("js/dgt-project-master.js"), true);
        wp_register_style('flex-idx-filter-pages-css', FLEX_IDX_URI . 'css/infowindows.css', array('flex-idx-search-css'), iboost_get_mod_time("css/infowindows.css"));
        wp_register_script('flex-idx-filter-js-scroll', FLEX_IDX_URI . 'js/perfect-scrollbar.jquery.min.js', array('jquery'), iboost_get_mod_time("js/perfect-scrollbar.jquery.min.js"));
        wp_register_script('flex-idx-filter-jquery-ui', FLEX_IDX_URI . 'js/jquery-ui.min.js', array('jquery'), iboost_get_mod_time("js/jquery-ui.min.js"));
        wp_register_script('flex-idx-filter-jquery-ui-touch', FLEX_IDX_URI . 'js/jquery.ui.touch-punch.min.js', array('flex-idx-filter-jquery-ui'), iboost_get_mod_time("js/jquery.ui.touch-punch.min.js"));
        // quick search assets
        wp_register_style('idxboost-quick-search-css', FLEX_IDX_URI . 'css/idxboost-quick-search.css', array(), iboost_get_mod_time("css/idxboost-quick-search.css"));
        wp_register_script(
            'idxboost-quick-search-js',
            FLEX_IDX_URI . 'js/idxboost-quick-search.js',
            array('jquery', 'underscore', 'underscore-mixins', 'flex-idx-filter-jquery-ui-touch'),
            iboost_get_mod_time("js/idxboost-quick-search.js")
        );
        wp_register_script('idxboost_filter_js', FLEX_IDX_URI . 'js/idxboost_filter.js', array(), iboost_get_mod_time("js/idxboost_filter.js"));

        //wp_register_script('flex-idx-filter-handler', FLEX_IDX_URI . 'js/idxboost_handlers_modals.js',array('jquery'));
        wp_register_script('flex-idx-filter-handler', FLEX_IDX_URI . 'js/idxboost_handlers_modals.js', array(
            'jquery',
            'flex-idx-search-filter-slider',
            'handlebars',
        ), iboost_get_mod_time("js/idxboost_handlers_modals.js"));

        wp_register_script('flex-idx-filter-js', FLEX_IDX_URI . 'js/dgt-filter-master.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/dgt-filter-master.js"));
        wp_register_script('idx_off_market_listing', FLEX_IDX_URI . 'js/js-off-market-listing-collection.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/js-off-market-listing-collection.js"));

        wp_register_script('idx_off_market_listing_carrosel', FLEX_IDX_URI . 'js/off-market-listing-carrosel.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/off-market-listing-carrosel.js"));

        wp_register_script('ib_slider_filter', FLEX_IDX_URI . 'js/ib-slider-filter.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            //'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/ib-slider-filter.js"));

        wp_register_script('ib_slider_filter_boost', FLEX_IDX_URI . 'js/ib-slider-filter-commercial.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            //'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/ib-slider-filter.js"));

        wp_register_script('ib_slider_building_boost', FLEX_IDX_URI . 'js/slider_building_collection.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            //'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/slider_building_collection.js"));

        wp_register_script('ib_slider_filter_boost_agent_office', FLEX_IDX_URI . 'js/ib_slider_filter_boost_agent_office.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            //'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/ib_slider_filter_boost_agent_office.js"));


        wp_register_script('idxboost_exclusive_listing', FLEX_IDX_URI . 'js/idxboost_exclusive_listing.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/idxboost_exclusive_listing.js"));

        wp_register_script('idxboost_filter_boost', FLEX_IDX_URI . 'js/idxboost_filter_boost.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/idxboost_filter_boost.js"));

        wp_register_script('idxboost_dinamic_agent_office', FLEX_IDX_URI . 'js/idxboost_dinamic_agent_office.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/idxboost_dinamic_agent_office.js"));

        wp_register_script('idxboost_slider_type', FLEX_IDX_URI . 'js/flex-idx-slider-type.js', array(
            'underscore',
            'flex-idx-filter-handler',
            'idxboost_filter_js',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            //'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/flex-idx-slider-type.js"));

        $translation_array = $custom_strings;
        wp_localize_script('flex-idx-filter-js', 'word_translate', $translation_array);
        // filter pages [end]

        wp_register_script('flex-idx-building-inventory-js', FLEX_IDX_URI . 'js/idxboost-building-collection.js', array(
            'underscore-mixins',
            'underscore',
            'flex-idx-filter-handler',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-idx-master',
            'flex-propertiesbuilding-plugin',
            'flex-lazyload-plugin'
            //'flex-idx-slider',
        ), iboost_get_mod_time("js/idxboost-building-collection.js"));


        wp_register_script('flex-idx-sub-area-js', FLEX_IDX_URI . 'js/idx-comunity-page.js', array(
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'google-maps-api',
            'google-maps-utility-library-richmarker',
            'google-maps-utility-library-infobubble',
            'flex-fusioncharts-plugin',
            'flex-dataTablesbuilding-plugin',
            'flex-idx-master',
            'flex-propertiesbuilding-plugin',
            'flex-condosbuilding-plugin',
            'flex-lazyload-plugin',
        ), iboost_get_mod_time("js/dgt-building-js.js"));
        wp_localize_script('flex-idx-sub-area-js', 'flex_idx_filter_params', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/")
        ));


        wp_localize_script('idxboost_filter_boost', 'flex_idx_filter_params', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/")
        ));

        wp_localize_script('idxboost_dinamic_agent_office', 'flex_idx_filter_params', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/")
        ));


        wp_register_script('flex-idx-sub-area-inventory-js', FLEX_IDX_URI . 'js/idxboost-sub-area-collection.js', array(
            'underscore-mixins',
            'underscore',
            'flex-idx-filter-handler',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-idx-master',
            'flex-propertiesbuilding-plugin',
            'flex-lazyload-plugin'
            //'flex-idx-slider',
        ), iboost_get_mod_time("js/idxboost-sub-area-collection.js"));

        wp_register_script('get-video-id-js', FLEX_IDX_URI . 'js/get-video-id.min.js', '', iboost_get_mod_time("js/get-video-id.min.js"));

        wp_register_script('flex-idx-single-property-collection-js', FLEX_IDX_URI . 'js/idxboost-single-property-collection.js', array(
            'underscore-mixins',
            'underscore',
            'flex-idx-filter-handler',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-idx-master',
            'flex-propertiesbuilding-plugin',
            'flex-lazyload-plugin',
            'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
            'get-video-id-js'
            //'flex-idx-slider',
        ), iboost_get_mod_time("js/idxboost-single-property-collection.js"));


        wp_register_script('slider-single-property-collection-js', FLEX_IDX_URI . 'js/flex-slider-single-property.js', array(
            'underscore-mixins',
            'underscore',
            'flex-idx-filter-handler',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-idx-master',
            'flex-propertiesbuilding-plugin',
            'flex-lazyload-plugin',
            'get-video-id-js'
            //'flex-idx-slider',
        ), iboost_get_mod_time("js/idxboost-single-property-collection.js"));


        wp_localize_script('flex-idx-building-inventory-js', 'word_translate', $translation_array);
        wp_localize_script('flex-idx-building-inventory-js', 'idxboost_collection_params', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'wpsite' => get_permalink(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'subarealink' => rtrim($flex_idx_info["pages"]['flex_idx_sub_area']['guid'], "/"),
            'offmarket' => rtrim($flex_idx_info["pages"]['flex_idx_sub_area']['guid'], "/"),
            'shareWithFriendEndpoint' => FLEX_IDX_API_SHARE_PROPERTY,
            'requestInformationEndpoint' => FLEX_IDX_API_REQUEST_INFO_PROPERTY,
            'underscore-mixins',
            'underscore',
            'flex-idx-master',
            'flex-propertiesbuilding-plugin',
            'flex-lazyload-plugin'
        ));

        wp_localize_script('flex-idx-sub-area-inventory-js', 'word_translate', $translation_array);
        wp_localize_script('flex-idx-sub-area-inventory-js', 'idxboost_collection_params', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'wpsite' => get_permalink(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'subarealink' => rtrim($flex_idx_info["pages"]['flex_idx_sub_area']['guid'], "/"),
            'off_market_listing_link' => rtrim($flex_idx_info["pages"]['flex_idx_off_market_listing']['guid'], "/"),
            'underscore-mixins',
            'underscore',
            'flex-idx-master',
            'flex-propertiesbuilding-plugin',
            'flex-lazyload-plugin'
        ));

        wp_register_script('ib-track-building-view-js', FLEX_IDX_URI . 'js/ib-track-building-view.js', [
            'flex-auth-check'
        ], iboost_get_mod_time("js/ib-track-building-view.js"));

        wp_localize_script("ib-track-building-view-js", "__track_building_view", [
            "updateEventUri" => IDX_BOOST_TRACK_COLLECTION_VIEWS

        ]);

        wp_register_script('ib-track-display-filter-view-js', FLEX_IDX_URI . 'js/ib-track-display-filter-view.js', [
            'flex-auth-check'
        ], iboost_get_mod_time("js/ib-track-display-filter-view.js"));

        wp_localize_script("ib-track-display-filter-view-js", "__track_display_filter_view", [
            "updateEventUri" => IDX_BOOST_TRACK_COLLECTION_VIEWS
        ]);


        wp_register_script('flex-condosbuilding-plugin', FLEX_IDX_URI . 'js/condo-js.js', array(), iboost_get_mod_time("js/condo-js.js"));
        wp_register_script('flex-dataTablesbuilding-plugin', FLEX_IDX_URI . 'js/jquery.dataTables.min.js', array(), iboost_get_mod_time("js/jquery.dataTables.min.js"));
        wp_register_script('flex-fusioncharts-core', FLEX_IDX_URI . 'js/fusioncharts.js', array(), iboost_get_mod_time("js/fusioncharts.js"));
        wp_register_script('flex-fusioncharts-plugin', FLEX_IDX_URI . 'js/fusioncharts.charts.js', array('flex-fusioncharts-core'), iboost_get_mod_time("js/fusioncharts.charts.js"));
        wp_register_script('flex-propertiesbuilding-plugin', FLEX_IDX_URI . 'js/properties-js.js', array(), iboost_get_mod_time("js/properties-js.js"));
        wp_register_script('flex-dgtmasterbuilding-plugin', FLEX_IDX_URI . 'js/dgt-master.min.js', array(), iboost_get_mod_time("js/dgt-master.min.js"));
        wp_register_script('flex-idx-building-js', FLEX_IDX_URI . 'js/dgt-building-js.js', array(
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'google-maps-api',
            'google-maps-utility-library-richmarker',
            'google-maps-utility-library-infobubble',
            'flex-fusioncharts-plugin',
            'flex-dataTablesbuilding-plugin',
            'flex-idx-master',
            'flex-propertiesbuilding-plugin',
            'flex-condosbuilding-plugin',
            'flex-lazyload-plugin',
        ), iboost_get_mod_time("js/dgt-building-js.js"));
        wp_localize_script('flex-idx-building-js', 'flex_idx_filter_params', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/")
        ));
        wp_register_script('flex-idx-alerts-js', FLEX_IDX_URI . 'js/dgt-alerts-js.js', array('jquery'), iboost_get_mod_time("js/dgt-alerts-js.js"));
        wp_localize_script('flex-idx-alerts-js', 'flex_idx_alerts_params', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search']
        ));
        // search results [start]
        wp_register_script('flex-idx-master', FLEX_IDX_URI . 'js/dgt-master.js', array('jquery'), iboost_get_mod_time("js/dgt-master.js"));
        wp_localize_script('flex-idx-master', 'flex_idx_gene', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'siteUrl' => $flex_idx_info["website_url"]
        ));
        wp_register_script('flex-lazyload-plugin', FLEX_IDX_URI . 'js/lazyload.transpiled.min.js', array(), iboost_get_mod_time("js/lazyload.transpiled.min.js"));
        wp_register_script('flex-idx-search-results-js', FLEX_IDX_URI . 'js/flex-search.js', array(
            'flex-lazyload-plugin',
            'underscore',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'google-maps-api',
            'google-maps-utility-library-richmarker',
            'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/flex-search.js"));
        // search results [end]
        // filter pages
        wp_localize_script('flex-idx-filter-handler', '__flex_idx_filter_regular', array(
            'accessToken' => flex_idx_get_access_token(),
            'hackbox' => $flex_idx_info["agent"]["hackbox"],
            'agentFullName' => $flex_idx_info["agent"]["agent_first_name"] . " " . $flex_idx_info["agent"]["agent_last_name"],
            'agentPhoto' => $flex_idx_info["agent"]["agent_contact_photo_profile"],
            'agentPhone' => $flex_idx_info["agent"]["agent_contact_phone_number"],
            'lookupSearchFilter' => FLEX_IDX_API_SEARCH_FILTER,
            'lookupSearchCommercialFilter' => FLEX_IDX_API_SEARCH_COMMERCIAL_FILTER,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'trackListingsDetail' => FLEX_IDX_API_SEARCH_TRACK,
            'saveListings' => FLEX_IDX_API_SEARCH_FILTER_SAVE,
            'shareWithFriendEndpoint' => FLEX_IDX_API_SHARE_PROPERTY,
            'requestInformationEndpoint' => FLEX_IDX_API_REQUEST_INFO_PROPERTY,
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'lookupAutocomplete' => FLEX_IDX_SERVICE_SUGGESTIONS,
            'accessToken' => flex_idx_get_access_token(),
            'boardId' => $flex_idx_info['board_id'],
            'search' => $flex_idx_info['search'],
            'fields' => 'address,building,city,street,subdivision,zip',
            'searchFilterPermalink' => get_permalink(),
            'leadFirstName' => (!empty($flex_idx_lead["lead_info"]["first_name"])) ? $flex_idx_lead["lead_info"]["first_name"] : "",
            'leadLastName' => (!empty($flex_idx_lead["lead_info"]["last_name"])) ? $flex_idx_lead["lead_info"]["last_name"] : "",
            'leadEmailAddress' => (!empty($flex_idx_lead["lead_info"]["email_address"])) ? $flex_idx_lead["lead_info"]["email_address"] : "",
            'leadPhoneNumber' => (!empty($flex_idx_lead["lead_info"]["phone_number"])) ? $flex_idx_lead["lead_info"]["phone_number"] : ""
        ));

        $objoffmarket = get_post_type_object('idx-off-market');

        wp_localize_script('idx_off_market_listing_carrosel', 'idx_param_off_market_slider', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'searchFilterPermalink' => get_permalink(),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => get_site_url() . '/' . @$objoffmarket->rewrite['slug'],
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'sitewp' => get_permalink()
        ));


        wp_localize_script('idxboost_slider_type', 'idx_param_slider', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'searchFilterPermalink' => get_permalink(),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'sitewp' => get_permalink()
        ));

        wp_localize_script('ib_slider_filter', 'idx_param_slider', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'searchFilterPermalink' => get_permalink(),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'sitewp' => get_permalink()
        ));

        wp_localize_script('ib_slider_filter_boost', 'idx_param_slider', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'searchFilterPermalink' => get_permalink(),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'sitewp' => get_permalink()
        ));

        wp_localize_script('ib_slider_building_boost', 'idx_param_slider', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'searchFilterPermalink' => get_permalink(),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'sitewp' => get_permalink()
        ));


        wp_localize_script('ib_slider_filter_boost_agent_office', 'idx_param_slider', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'searchFilterPermalink' => get_permalink(),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'sitewp' => get_permalink()
        ));


        wp_localize_script('idxboost_exclusive_listing', 'flex_idx_filter_params', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'searchFilterPermalink' => get_permalink(),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'sitewp' => get_permalink()
        ));

        wp_localize_script('idx_off_market_listing', 'flex_idx_filter_params', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'searchFilterPermalink' => get_permalink(),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'sitewp' => get_permalink()
        ));

        wp_localize_script('flex-idx-filter-js', 'flex_idx_filter_params', array(
            'rk' => get_option('flex_idx_alerts_keys'),
            'wp_web_id' => get_option('flex_idx_alerts_app_id'),
            'saveListings' => FLEX_IDX_API_REGULAR_FILTER_SAVE,
            'lookupListingsDetail' => FLEX_IDX_API_SEARCH_LISTING,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'boardId' => $flex_idx_info['board_id'],
            'searchFilterPermalink' => get_permalink(),
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'sitewp' => get_permalink()
        ));
        wp_register_script('flex-idx-jquery-ui-timepicker', FLEX_IDX_URI . 'js/jquery-ui-timepicker-addon.js', array('jquery'), iboost_get_mod_time("js/jquery-ui-timepicker-addon.js"));
        // saved listings
        wp_register_script('flex-idx-saved-listing', FLEX_IDX_URI . 'js/flex-idx-saved-listing.js', array(
            'jquery',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-idx-jquery-ui-timepicker'
        ), iboost_get_mod_time("js/flex-idx-saved-listing.js"));
        wp_localize_script('flex-idx-saved-listing', 'flex_idx_saved_listing', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'siteUrl' => $flex_idx_info["website_url"]
        ));
        // saved searches
        // wp_register_script('flex-idx-saved-searches', FLEX_IDX_URI . 'js/flex-idx-saved-searches.js', array('flex-idx-search-results-js'));
        wp_register_script('flex-idx-saved-searches', FLEX_IDX_URI . 'js/flex-idx-saved-searches.js', array(), iboost_get_mod_time("js/flex-idx-saved-searches.js"));
        wp_localize_script('flex-idx-saved-searches', 'flex_idx_saved_searches', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'siteUrl' => $flex_idx_info["website_url"]
        ));
        // my profile
        wp_register_script('flex-idx-profile', FLEX_IDX_URI . 'js/flex-idx-profile.js', array('jquery'), iboost_get_mod_time("js/flex-idx-profile.js"));
        wp_localize_script('flex-idx-profile', 'flex_idx_profile', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'siteUrl' => $flex_idx_info["website_url"]
        ));
        // property
        wp_localize_script('flex-idx-property-js', 'flex_idx_property_params', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
        ));
        // search results
        $translation_array = $custom_strings;
        wp_localize_script('flex-idx-search-results-js', 'word_translate', $translation_array);
        wp_localize_script('flex-idx-search-results-js', 'flex_idx_search_params', array(
            'lookupSearch' => FLEX_IDX_API_SEARCH,
            'accessToken' => flex_idx_get_access_token(),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'searchUrl' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/"),
            'siteUrl' => $flex_idx_info["website_url"],
            'params' => $flex_idx_info['search'],
            'anonymous' => ($flex_idx_lead === false) ? 'yes' : 'no',
            'loginUrl' => wp_login_url(),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),
            'searchPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_search"]["guid"], "/")
        ));

        wp_register_style("idxboost-quick-search-v2-theme", FLEX_IDX_URI . "css/idxboost-quick-search-v2.css", array(), iboost_get_mod_time("css/idxboost-quick-search-v2.css"));
        wp_register_script("idxboost-quick-search-v2", FLEX_IDX_URI . "js/idxboost-quick-search-v2.js", array(
            "jquery",
            "underscore",
            "underscore-mixins",
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
        ), iboost_get_mod_time("js/idxboost-quick-search-v2.js"));
        wp_localize_script("idxboost-quick-search-v2", "__ib_quick_search", array(
            "searchUrl" => $flex_idx_info["pages"]["flex_idx_search"]["guid"],
            "priceRentValues" => $flex_idx_info["search"]["price_rent_range"],
            "priceSaleValues" => $flex_idx_info["search"]["price_sale_range"]
        ));
    }
}
/*****************************************/
if (!function_exists('ib_tables_building_collection')) {
    function ib_tables_building_collection()
    {
        wp_enqueue_script('flex-idx-building-inventory-js');
        wp_enqueue_script('flex-fusioncharts-plugin');
        wp_enqueue_script('flex-dataTablesbuilding-plugin');
    }
}

if (!function_exists('ib_sub_area_footer')) {
    function ib_sub_area_footer()
    {
        wp_enqueue_script('flex-idx-sub-area-js');
    }
}

if (!function_exists('ib_tables_sub_area_collection')) {
    function ib_tables_sub_area_collection()
    {
        wp_enqueue_script('flex-idx-sub-area-inventory-js');
        wp_enqueue_script('flex-fusioncharts-plugin');
        wp_enqueue_script('flex-dataTablesbuilding-plugin');
    }
}

if (!function_exists('greatsliderLoad')) {
    function greatsliderLoad()
    {
        wp_enqueue_script('flex-print-area', FLEX_IDX_URI . 'js/jquery.PrintArea.js', array('flex-pusher-js', 'flex-cookies-manager', 'jquery'), iboost_get_mod_time("js/jquery.PrintArea.js"), true);
        wp_register_script('greatslider', FLEX_IDX_URI . 'js/greatslider.jquery.min.js', array("jquery"), iboost_get_mod_time("js/greatslider.jquery.min.js"));
        wp_register_script('flex-idx-slider-main', FLEX_IDX_URI . 'js/greatslider-main.js', array("jquery"), iboost_get_mod_time("js/greatslider-main.js"));
        wp_enqueue_script('flex-idx-slider', FLEX_IDX_URI . 'js/greatslider-main.js', array('jquery', 'greatslider'), iboost_get_mod_time("js/greatslider-main.js"), true);

        global $flex_idx_info;

        if (!empty($flex_idx_info['agent']['has_cms']) && $flex_idx_info['agent']['has_cms'] != false) {

            wp_enqueue_script('idx_boost_js_base', IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/js/base.js', array('jquery'), false, true);
            wp_enqueue_script('get-video-id-js');

            global $post;
            $idx_post_type = get_post_meta($post->ID, 'idx_page_type', true);

            if (is_home() || is_front_page() || $idx_post_type == 'custom' || $idx_post_type == 'landing') {
                wp_enqueue_script('idx_boost_js_home', IDX_BOOST_SPW_BUILDER_SERVICE . '/assets/js/home.js', array(), false, true);
            }
            $page_slug = explode("/", trim($_SERVER["REQUEST_URI"], '/'));
        }

        //wp_enqueue_script('modal-properties', FLEX_IDX_URI . 'js/modal-properties.js');
    }
}
add_action('wp_footer', 'greatsliderLoad');
/*****************************************/
if (!function_exists('flex_idx_admin_register_assets')) {
    function flex_idx_admin_register_assets()
    {
        wp_register_style('flex-idx-admin', FLEX_IDX_URI . 'css/flex-idx-admin.css');
        // cookies manager
        wp_register_script('flex-cookies-manager', FLEX_IDX_URI . 'js/js.cookie.min.js', array(), iboost_get_mod_time("js/js.cookie.min.js"), true);
        wp_register_script('flex-idx-admin-js', FLEX_IDX_URI . 'js/flex-idx-admin.js', array('jquery', 'flex-cookies-manager'));
        wp_register_script('flex-idx-admin-import-js', FLEX_IDX_URI . 'js/idxboost_import_admin.js', array('jquery'));
        wp_register_script('flex-idx-tools-js', FLEX_IDX_URI . 'js/flex-idx-tools.js', array('jquery'));
        wp_register_style('flex-idx-admin-pages', FLEX_IDX_URI . 'css/flex-idx-admin-pages.css');
        wp_register_script('flex-idx-admin-pages-js', FLEX_IDX_URI . 'js/flex-idx-admin-pages.js', array('jquery'));
        wp_localize_script('flex-idx-admin-js', 'flex_idx_admin_js', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'documentationurl' => admin_url('admin.php?page=flex-idx-settings'),
        ));
        wp_localize_script('flex-idx-admin-pages-js', 'flex_idx_admin_pages_js', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
        ));
        wp_localize_script('flex-idx-admin-import-js', 'flex_idx_admin_import_js', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
        ));

        wp_localize_script('flex-idx-tools-js', 'idx_admin_tools', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
        ));
    }
}
if (!function_exists('flex_idx_admin_enqueue_assets')) {
    function flex_idx_admin_enqueue_assets()
    {
        wp_enqueue_style('flex-idx-admin');
        wp_enqueue_script('flex-idx-admin-js');
        wp_enqueue_script('flex-idx-admin-import-js');
    }
}
if (!function_exists('flex_idx_admin_pages_list_enqueue_assets')) {
    function flex_idx_admin_pages_list_enqueue_assets()
    {
        wp_enqueue_style('flex-idx-admin');
        wp_enqueue_style('flex-idx-admin-pages');
        wp_enqueue_script('flex-idx-admin-pages-js');
        wp_enqueue_script('flex-idx-admin-import-js');
    }
}
if (!function_exists('flex_idx_admin_render_default_page')) {
    function flex_idx_admin_render_default_page()
    {
        $idxboost_registration_key = get_option('idxboost_registration_key');
        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/admin/default.php')) {
            return include IDXBOOST_OVERRIDE_DIR . '/views/admin/default.php';
        } else {
            return include FLEX_IDX_PATH . '/views/admin/default.php';
        }
    }
}

if (!function_exists('flex_idx_admin_render_tools_page')) {
    function flex_idx_admin_render_tools_page()
    {
        global $wpdb;
        $tbl_idxboost_tools = $wpdb->prefix . 'idxboost_setting';
        $descr_tools_map_style = [];

        /*create table*/
        if ($wpdb->get_var("SHOW TABLES LIKE '$tbl_idxboost_tools'") != $tbl_idxboost_tools) {
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $tbl_idxboost_tools (
                  id int NOT NULL Primary KEY AUTO_INCREMENT,
                  idx_map_style MEDIUMTEXT NOT NULL,
                  UNIQUE KEY id (id)
             ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
        /*create table*/

        $idxboost_setting_tools_map_style = $wpdb->get_col("SELECT idx_map_style FROM {$tbl_idxboost_tools}; ");
        if (is_array($idxboost_setting_tools_map_style) && count($idxboost_setting_tools_map_style) > 0) {
            $descr_tools_map_style = $idxboost_setting_tools_map_style[0];
        }

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/admin/idx_tools.php')) {
            return include IDXBOOST_OVERRIDE_DIR . '/views/admin/idx_tools.php';
        } else {
            return include FLEX_IDX_PATH . '/views/admin/idx_tools.php';
        }
    }
}

if (!function_exists('flex_idx_admin_render_importation_page')) {
    function flex_idx_admin_render_importation_page()
    {
        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/admin/import_data.php')) {
            return include IDXBOOST_OVERRIDE_DIR . '/views/admin/import_data.php';
        } else {
            return include FLEX_IDX_PATH . '/views/admin/import_data.php';
        }
    }
}
if (!function_exists('flex_idx_admin_render_documentation_page')) {
    function flex_idx_admin_render_documentation_page()
    {
        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/admin/documentation.php')) {
            return include IDXBOOST_OVERRIDE_DIR . '/views/admin/documentation.php';
        } else {
            return include FLEX_IDX_PATH . '/views/admin/documentation.php';
        }
    }
}
if (!function_exists('flex_idx_admin_render_launch_page')) {
    function flex_idx_admin_render_launch_page()
    {
        wp_enqueue_script('flex-idx-admin-js');
        $flex_idx_registration_launch = get_option('flex_idx_registration_launch');
        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/admin/launch.php')) {
            return include IDXBOOST_OVERRIDE_DIR . '/views/admin/launch.php';
        } else {
            return include FLEX_IDX_PATH . '/views/admin/launch.php';
        }
    }
}


// Add Custom Menu
add_action('admin_menu', 'flex_idx_create_editor_root_menu');
if (!function_exists('flex_idx_create_editor_root_menu')) {
    function flex_idx_create_editor_root_menu()
    {
        $flex_idx_page = add_menu_page('IDX Boost - Settings', 'IDX Boost', 'editor', 'flex-idx-editor', 'flex_idx_admin_render_default_page', FLEX_IDX_URI . 'images/rocket.svg');

        add_action('admin_print_scripts-' . $flex_idx_page, 'flex_idx_admin_enqueue_assets');
        if (get_option('idxboost_client_status') == 'active') {
            // $flex_idx_registration_launch = get_option('flex_idx_registration_launch');
            // if ($flex_idx_registration_launch==false) {
            //     $flex_idx_pages_admin_launch = add_submenu_page('flex-idx', 'IDX Boost - Launch', 'Launch My Site', 'administrator', 'flex-idx-launch', 'flex_idx_admin_render_launch_page');
            // }
            add_submenu_page('flex-idx-editor', 'Map Search Filters', 'Map Search Filters', 'editor', 'edit.php?post_type=flex-landing-pages', null);
            add_submenu_page('flex-idx-editor', 'Display Filters', 'Display Filters', 'editor', 'edit.php?post_type=flex-filter-pages', null);
            add_submenu_page('flex-idx-editor', 'My Buildings', 'My Buildings', 'editor', 'edit.php?post_type=flex-idx-building', null);
            add_submenu_page('flex-idx-editor', 'My Master Plans', 'My Master Plans', 'editor', 'edit.php?post_type=idx-sub-area', null);
            add_submenu_page('flex-idx-editor', 'Off Market Inventory', 'Off Market Inventory', 'editor', 'edit.php?post_type=idx-off-market', null);
            add_submenu_page('flex-idx-editor', 'Page’s URL Slug', 'Page’s URL Slug', 'editor', 'edit.php?post_type=flex-idx-pages', null);
            //add_submenu_page('flex-idx', 'My IDX Agents - FlexIDX', 'My IDX Agents', 'administrator', 'edit.php?post_type=idx-agents', null);
            $flex_idx_pages_admin = add_submenu_page('flex-idx-editor', 'IDX Boost - Tools', 'My Tools', 'editor', 'flex-idx-tools', 'flex_idx_admin_render_tools_page');
            //$flex_idx_pages_admin = add_submenu_page('flex-idx', 'IDX Boost - Documentation', 'Documentation', 'administrator', 'flex-idx-settings', 'flex_idx_admin_render_documentation_page');
            //$flex_idx_pages_admin = add_submenu_page('flex-idx', 'IDX Boost - Import', 'Import Data', 'administrator', 'flex-idx-import-data', 'flex_idx_admin_render_importation_page');
            add_action('admin_print_scripts-' . $flex_idx_pages_admin, 'flex_idx_admin_pages_list_enqueue_assets');
        }
    }
}

if (!function_exists('flex_idx_create_admin_root_menu')) {
    function flex_idx_create_admin_root_menu()
    {
        $flex_idx_page = add_menu_page('IDX Boost - Settings', 'IDX Boost', 'administrator', 'flex-idx', 'flex_idx_admin_render_default_page', FLEX_IDX_URI . 'images/rocket.svg');
        add_action('admin_print_scripts-' . $flex_idx_page, 'flex_idx_admin_enqueue_assets');
        if (get_option('idxboost_client_status') == 'active') {
            // $flex_idx_registration_launch = get_option('flex_idx_registration_launch');
            // if ($flex_idx_registration_launch==false) {
            //     $flex_idx_pages_admin_launch = add_submenu_page('flex-idx', 'IDX Boost - Launch', 'Launch My Site', 'administrator', 'flex-idx-launch', 'flex_idx_admin_render_launch_page');
            // }
            add_submenu_page('flex-idx', 'Map Search Filters', 'Map Search Filters', 'administrator', 'edit.php?post_type=flex-landing-pages', null);
            add_submenu_page('flex-idx', 'Display Filters', 'Display Filters', 'administrator', 'edit.php?post_type=flex-filter-pages', null);
            add_submenu_page('flex-idx', 'My Buildings', 'My Buildings', 'administrator', 'edit.php?post_type=flex-idx-building', null);
            add_submenu_page('flex-idx', 'My Master Plans', 'My Master Plans', 'administrator', 'edit.php?post_type=idx-sub-area', null);
            add_submenu_page('flex-idx', 'Off Market Inventory', 'Off Market Inventory', 'administrator', 'edit.php?post_type=idx-off-market', null);
            add_submenu_page('flex-idx', 'Page’s URL Slug', 'Page’s URL Slug', 'administrator', 'edit.php?post_type=flex-idx-pages', null);
            //add_submenu_page('flex-idx', 'My IDX Agents - FlexIDX', 'My IDX Agents', 'administrator', 'edit.php?post_type=idx-agents', null);
            $flex_idx_pages_admin = add_submenu_page('flex-idx', 'IDX Boost - Tools', 'My Tools', 'administrator', 'flex-idx-tools', 'flex_idx_admin_render_tools_page');
            //$flex_idx_pages_admin = add_submenu_page('flex-idx', 'IDX Boost - Documentation', 'Documentation', 'administrator', 'flex-idx-settings', 'flex_idx_admin_render_documentation_page');
            //$flex_idx_pages_admin = add_submenu_page('flex-idx', 'IDX Boost - Import', 'Import Data', 'administrator', 'flex-idx-import-data', 'flex_idx_admin_render_importation_page');
            add_action('admin_print_scripts-' . $flex_idx_pages_admin, 'flex_idx_admin_pages_list_enqueue_assets');
        }
    }
}
// start configuration settings
if (!function_exists('flex_idx_settings_configuration')) {
    function flex_idx_settings_configuration($input)
    {
        $valid = get_option('flex-idx-settings-configuration-options');
        $layout_style = sanitize_text_field($input['flex-idx-settings-configuration-layout']);
        $button_color = sanitize_text_field($input['flex-idx-settings-configuration-color']);
        $css_override = sanitize_text_field($input['flex-idx-settings-override-css']);
        $valid['flex-idx-settings-configuration-layout'] = $layout_style;
        $valid['flex-idx-settings-configuration-color'] = $button_color;
        $valid['flex-idx-settings-override-css'] = $css_override;
        return $valid;
    }
}
if (!function_exists('flex_idx_settings_configuration_layout_display')) {
    function flex_idx_settings_configuration_layout_display()
    {
        $configuration_options = get_option('flex-idx-settings-configuration-options');
        $configuration_layout = isset($configuration_options['flex-idx-settings-configuration-layout']) ? $configuration_options['flex-idx-settings-configuration-layout'] : '';
        echo '<select id="flex-idx-settings-configuration-layout" name="flex-idx-settings-configuration-options[flex-idx-settings-configuration-layout]">';
        echo '<option value="responsive" ' . selected($configuration_layout, 'responsive', false) . '>Responsive</option>';
        echo '<option value="fixed" ' . selected($configuration_layout, 'fixed', false) . '>Fixed-width</option>';
        echo '</select>';
    }
}
if (!function_exists('flex_idx_settings_configuration_color_display')) {
    function flex_idx_settings_configuration_color_display()
    {
        $configuration_options = get_option('flex-idx-settings-configuration-options');
        $configuration_color = isset($configuration_options['flex-idx-settings-configuration-color']) ? $configuration_options['flex-idx-settings-configuration-color'] : '';
        echo '<select id="flex-idx-settings-configuration-color" name="flex-idx-settings-configuration-options[flex-idx-settings-configuration-color]">';
        echo '<option value="gray" ' . selected($configuration_color, 'gray', false) . '>Gray</option>';
        echo '<option value="red" ' . selected($configuration_color, 'red', false) . '>Red</option>';
        echo '<option value="green" ' . selected($configuration_color, 'green', false) . '>Green</option>';
        echo '<option value="orange" ' . selected($configuration_color, 'orange', false) . '>Orange</option>';
        echo '<option value="blue" ' . selected($configuration_color, 'blue', false) . '>Blue</option>';
        echo '<option value="light_blue" ' . selected($configuration_color, 'light_blue', false) . '>Light Blue</option>';
        echo '</select>';
    }
}
if (!function_exists('flex_idx_settings_configuration_override_css_display')) {
    function flex_idx_settings_configuration_override_css_display()
    {
        $configuration_options = get_option('flex-idx-settings-configuration-options');
        $configuration_override_css = isset($configuration_options['flex-idx-settings-override-css']) ? $configuration_options['flex-idx-settings-override-css'] : '';
        echo '<textarea id="flex-idx-settings-override-css" name="flex-idx-settings-configuration-options[flex-idx-settings-override-css]" class="widefat" rows="15">' . $configuration_override_css . '</textarea>';
    }
}
if (!function_exists('flex_idx_settings_configuration_description')) {
    function flex_idx_settings_configuration_description()
    {
        return '';
    }
}
if (!function_exists('flex_idx_register_settings_configuration_fn')) {
    function flex_idx_register_settings_configuration_fn()
    {
        register_setting('flex-idx-settings-configuration', 'flex-idx-settings-configuration-options', 'flex_idx_settings_configuration');
        add_settings_section('flex-idx-settings-configuration', '', 'flex_idx_settings_configuration_description', 'flex-idx-configuration-page');
        add_settings_field('flex-idx-settings-configuration-layout', 'Layout Style', 'flex_idx_settings_configuration_layout_display', 'flex-idx-configuration-page', 'flex-idx-settings-configuration', array(
            'label_for' => 'flex-idx-settings-configuration-layout',
        ));
        add_settings_field('flex-idx-settings-configuration-color', 'Button Color', 'flex_idx_settings_configuration_color_display', 'flex-idx-configuration-page', 'flex-idx-settings-configuration', array(
            'label_for' => 'flex-idx-settings-configuration-color',
        ));
        add_settings_field('flex-idx-settings-override-css', 'CSS Override', 'flex_idx_settings_configuration_override_css_display', 'flex-idx-configuration-page', 'flex-idx-settings-configuration', array(
            'label_for' => 'flex-idx-settings-override-css',
        ));
    }
}
// end configuration settings
// start bio settings
if (!function_exists('flex_idx_settings_bio')) {
    function flex_idx_settings_bio($input)
    {
        $valid = get_option('flex-idx-settings-bio-options');
        $display_name = sanitize_text_field($input['flex-idx-settings-bio-display-name']);
        $contact_phone = sanitize_text_field($input['flex-idx-settings-bio-contact-phone']);
        $contact_email = sanitize_text_field($input['flex-idx-settings-bio-contact-email']);
        $agent_photo = sanitize_text_field($input['flex-idx-settings-bio-agent-photo']);
        $agent_bio_text = sanitize_text_field($input['flex-idx-settings-bio-agent-bio-text']);
        $valid['flex-idx-settings-bio-display-name'] = $display_name;
        $valid['flex-idx-settings-bio-contact-phone'] = $contact_phone;
        $valid['flex-idx-settings-bio-contact-email'] = $contact_email;
        $valid['flex-idx-settings-bio-agent-photo'] = $agent_photo;
        $valid['flex-idx-settings-bio-agent-bio-text'] = $agent_bio_text;
        return $valid;
    }
}
if (!function_exists('flex_idx_settings_bio_display_name_display')) {
    function flex_idx_settings_bio_display_name_display()
    {
        $bio_options = get_option('flex-idx-settings-bio-options');
        $display_name = isset($bio_options['flex-idx-settings-bio-display-name']) ? $bio_options['flex-idx-settings-bio-display-name'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-bio-options[flex-idx-settings-bio-display-name]" id="flex-idx-settings-bio-display-name" value="' . $display_name . '">';
    }
}
if (!function_exists('flex_idx_settings_bio_contact_phone_display')) {
    function flex_idx_settings_bio_contact_phone_display()
    {
        $bio_options = get_option('flex-idx-settings-bio-options');
        $contact_phone = isset($bio_options['flex-idx-settings-bio-contact-phone']) ? $bio_options['flex-idx-settings-bio-contact-phone'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-bio-options[flex-idx-settings-bio-contact-phone]" id="flex-idx-settings-bio-contact-phone" value="' . $contact_phone . '">';
    }
}
if (!function_exists('flex_idx_settings_bio_contact_email_display')) {
    function flex_idx_settings_bio_contact_email_display()
    {
        $bio_options = get_option('flex-idx-settings-bio-options');
        $contact_email = isset($bio_options['flex-idx-settings-bio-contact-email']) ? $bio_options['flex-idx-settings-bio-contact-email'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-bio-options[flex-idx-settings-bio-contact-email]" id="flex-idx-settings-bio-contact-email" value="' . $contact_email . '">';
    }
}
if (!function_exists('flex_idx_settings_bio_agent_photo_display')) {
    function flex_idx_settings_bio_agent_photo_display()
    {
        $bio_options = get_option('flex-idx-settings-bio-options');
        $agent_photo = isset($bio_options['flex-idx-settings-bio-agent-photo']) ? $bio_options['flex-idx-settings-bio-agent-photo'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-bio-options[flex-idx-settings-bio-agent-photo]" id="flex-idx-settings-bio-agent-photo" value="' . $agent_photo . '">';
        echo '<p class="description">Enter an image URL or use an image from the Media Library</p>';
    }
}
if (!function_exists('flex_idx_settings_bio_agent_bio_display')) {
    function flex_idx_settings_bio_agent_bio_display()
    {
        $bio_options = get_option('flex-idx-settings-bio-options');
        $agent_bio_text = isset($bio_options['flex-idx-settings-bio-agent-bio-text']) ? $bio_options['flex-idx-settings-bio-agent-bio-text'] : '';
        echo '<textarea class="widefat" rows="15" name="flex-idx-settings-bio-options[flex-idx-settings-bio-agent-bio-text]" id="flex-idx-settings-bio-agent-bio-text">' . $agent_bio_text . '</textarea>';
    }
}
if (!function_exists('flex_idx_settings_bio_description')) {
    function flex_idx_settings_bio_description()
    {
        return '';
    }
}
if (!function_exists('flex_idx_register_settings_bio_fn')) {
    function flex_idx_register_settings_bio_fn()
    {
        register_setting('flex-idx-settings-bio', 'flex-idx-settings-bio-options', 'flex_idx_settings_bio');
        add_settings_section('flex-idx-settings-bio', '', 'flex_idx_settings_bio_description', 'flex-idx-bio-page');
        add_settings_field('flex-idx-settings-bio-display-name', 'Display Name', 'flex_idx_settings_bio_display_name_display', 'flex-idx-bio-page', 'flex-idx-settings-bio', array(
            'label_for' => 'flex-idx-settings-bio-display-name',
        ));
        add_settings_field('flex-idx-settings-bio-contact-phone', 'Contact Phone', 'flex_idx_settings_bio_contact_phone_display', 'flex-idx-bio-page', 'flex-idx-settings-bio', array(
            'label_for' => 'flex-idx-settings-bio-contact-phone',
        ));
        add_settings_field('flex-idx-settings-bio-contact-email', 'Contact Email', 'flex_idx_settings_bio_contact_email_display', 'flex-idx-bio-page', 'flex-idx-settings-bio', array(
            'label_for' => 'flex-idx-settings-bio-contact-email',
        ));
        add_settings_field('flex-idx-settings-bio-agent-photo', 'Agent Photo', 'flex_idx_settings_bio_agent_photo_display', 'flex-idx-bio-page', 'flex-idx-settings-bio', array(
            'label_for' => 'flex-idx-settings-bio-agent-photo',
        ));
        add_settings_field('flex-idx-settings-bio-agent-bio-text', 'Agent Bio Text', 'flex_idx_settings_bio_agent_bio_display', 'flex-idx-bio-page', 'flex-idx-settings-bio', array(
            'label_for' => 'flex-idx-settings-bio-agent-bio-text',
        ));
    }
}
// end bio settings
// start social settings
if (!function_exists('flex_idx_settings_social')) {
    function flex_idx_settings_social($input)
    {
        $valid = get_option('flex-idx-settings-social-options');
        $facebook = sanitize_text_field($input['flex-idx-settings-social-facebook']);
        $linkedin = sanitize_text_field($input['flex-idx-settings-social-linkedin']);
        $twitter = sanitize_text_field($input['flex-idx-settings-social-twitter']);
        $pinterest = sanitize_text_field($input['flex-idx-settings-social-pinterest']);
        $instagram = sanitize_text_field($input['flex-idx-settings-social-instagram']);
        $googleplus = sanitize_text_field($input['flex-idx-settings-social-googleplus']);
        $youtube = sanitize_text_field($input['flex-idx-settings-social-youtube']);
        $yelp = sanitize_text_field($input['flex-idx-settings-social-yelp']);
        $valid['flex-idx-settings-social-facebook'] = $facebook;
        $valid['flex-idx-settings-social-linkedin'] = $linkedin;
        $valid['flex-idx-settings-social-twitter'] = $twitter;
        $valid['flex-idx-settings-social-pinterest'] = $pinterest;
        $valid['flex-idx-settings-social-instagram'] = $instagram;
        $valid['flex-idx-settings-social-googleplus'] = $googleplus;
        $valid['flex-idx-settings-social-youtube'] = $youtube;
        $valid['flex-idx-settings-social-yelp'] = $yelp;
        return $valid;
    }
}
if (!function_exists('flex_idx_settings_social_facebook_display')) {
    function flex_idx_settings_social_facebook_display()
    {
        $social_options = get_option('flex-idx-settings-social-options');
        $facebook = isset($social_options['flex-idx-settings-social-facebook']) ? $social_options['flex-idx-settings-social-facebook'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-social-options[flex-idx-settings-social-facebook]" id="flex-idx-settings-social-facebook" value="' . $facebook . '">';
    }
}
if (!function_exists('flex_idx_settings_social_linkedin_display')) {
    function flex_idx_settings_social_linkedin_display()
    {
        $social_options = get_option('flex-idx-settings-social-options');
        $linkedin = isset($social_options['flex-idx-settings-social-linkedin']) ? $social_options['flex-idx-settings-social-linkedin'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-social-options[flex-idx-settings-social-linkedin]" id="flex-idx-settings-social-linkedin" value="' . $linkedin . '">';
    }
}
if (!function_exists('flex_idx_settings_social_twitter_display')) {
    function flex_idx_settings_social_twitter_display()
    {
        $social_options = get_option('flex-idx-settings-social-options');
        $twitter = isset($social_options['flex-idx-settings-social-twitter']) ? $social_options['flex-idx-settings-social-twitter'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-social-options[flex-idx-settings-social-twitter]" id="flex-idx-settings-social-twitter" value="' . $twitter . '">';
    }
}
if (!function_exists('flex_idx_settings_social_pinterest_display')) {
    function flex_idx_settings_social_pinterest_display()
    {
        $social_options = get_option('flex-idx-settings-social-options');
        $pinterest = isset($social_options['flex-idx-settings-social-pinterest']) ? $social_options['flex-idx-settings-social-pinterest'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-social-options[flex-idx-settings-social-pinterest]" id="flex-idx-settings-social-pinterest" value="' . $pinterest . '">';
    }
}
if (!function_exists('flex_idx_settings_social_instagram_display')) {
    function flex_idx_settings_social_instagram_display()
    {
        $social_options = get_option('flex-idx-settings-social-options');
        $instagram = isset($social_options['flex-idx-settings-social-instagram']) ? $social_options['flex-idx-settings-social-instagram'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-social-options[flex-idx-settings-social-instagram]" id="flex-idx-settings-social-instagram" value="' . $instagram . '">';
    }
}
if (!function_exists('flex_idx_settings_social_googleplus_display')) {
    function flex_idx_settings_social_googleplus_display()
    {
        $social_options = get_option('flex-idx-settings-social-options');
        $googleplus = isset($social_options['flex-idx-settings-social-googleplus']) ? $social_options['flex-idx-settings-social-googleplus'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-social-options[flex-idx-settings-social-googleplus]" id="flex-idx-settings-social-googleplus" value="' . $googleplus . '">';
    }
}
if (!function_exists('flex_idx_settings_social_youtube_display')) {
    function flex_idx_settings_social_youtube_display()
    {
        $social_options = get_option('flex-idx-settings-social-options');
        $youtube = isset($social_options['flex-idx-settings-social-youtube']) ? $social_options['flex-idx-settings-social-youtube'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-social-options[flex-idx-settings-social-youtube]" id="flex-idx-settings-social-youtube" value="' . $youtube . '">';
    }
}
if (!function_exists('flex_idx_settings_social_yelp_display')) {
    function flex_idx_settings_social_yelp_display()
    {
        $social_options = get_option('flex-idx-settings-social-options');
        $yelp = isset($social_options['flex-idx-settings-social-yelp']) ? $social_options['flex-idx-settings-social-yelp'] : '';
        echo '<input type="text" class="widefat" name="flex-idx-settings-social-options[flex-idx-settings-social-yelp]" id="flex-idx-settings-social-yelp" value="' . $yelp . '">';
    }
}
if (!function_exists('flex_idx_settings_social_description')) {
    function flex_idx_settings_social_description()
    {
        return '';
    }
}
if (!function_exists('flex_idx_register_settings_social_fn')) {
    function flex_idx_register_settings_social_fn()
    {
        register_setting('flex-idx-settings-social', 'flex-idx-settings-social-options', 'flex_idx_settings_social');
        add_settings_section('flex-idx-settings-social', '', 'flex_idx_settings_social_description', 'flex-idx-social-page');
        add_settings_field('flex-idx-settings-social-facebook', 'Facebook', 'flex_idx_settings_social_facebook_display', 'flex-idx-social-page', 'flex-idx-settings-social', array(
            'label_for' => 'flex-idx-settings-social-facebook',
        ));
        add_settings_field('flex-idx-settings-social-linkedin', 'LinkedIn', 'flex_idx_settings_social_linkedin_display', 'flex-idx-social-page', 'flex-idx-settings-social', array(
            'label_for' => 'flex-idx-settings-social-linkedin',
        ));
        add_settings_field('flex-idx-settings-social-twitter', 'Twitter', 'flex_idx_settings_social_twitter_display', 'flex-idx-social-page', 'flex-idx-settings-social', array(
            'label_for' => 'flex-idx-settings-social-twitter',
        ));
        add_settings_field('flex-idx-settings-social-pinterest', 'Pinterest', 'flex_idx_settings_social_pinterest_display', 'flex-idx-social-page', 'flex-idx-settings-social', array(
            'label_for' => 'flex-idx-settings-social-pinterest',
        ));
        add_settings_field('flex-idx-settings-social-instagram', 'Instagram', 'flex_idx_settings_social_instagram_display', 'flex-idx-social-page', 'flex-idx-settings-social', array(
            'label_for' => 'flex-idx-settings-social-instagram',
        ));
        add_settings_field('flex-idx-settings-social-googleplus', 'Google+', 'flex_idx_settings_social_googleplus_display', 'flex-idx-social-page', 'flex-idx-settings-social', array(
            'label_for' => 'flex-idx-settings-social-googleplus',
        ));
        add_settings_field('flex-idx-settings-social-youtube', 'YouTube', 'flex_idx_settings_social_youtube_display', 'flex-idx-social-page', 'flex-idx-settings-social', array(
            'label_for' => 'flex-idx-settings-social-youtube',
        ));
        add_settings_field('flex-idx-settings-social-yelp', 'Yelp', 'flex_idx_settings_social_yelp_display', 'flex-idx-social-page', 'flex-idx-settings-social', array(
            'label_for' => 'flex-idx-settings-social-yelp',
        ));
    }
}
// end social settings
if (!function_exists('flex_idx_list_cities')) {
    function flex_idx_list_cities()
    {
        global $wpdb;
        /* @todo pending cities */
        $list_cities = $wpdb->get_col('SELECT DISTINCT `name` FROM flex_idx_cities ORDER BY `name`');
        return $list_cities;
    }
}
/* extend user profile with custom fields */
if (!function_exists('flex_idx_profile_extend_fn')) {
    function flex_idx_profile_extend_fn($user)
    {
        ?>
        <h3>FlexIDX - Profile Info</h3>

        <table class="form-table">
            <tr>
                <th><label for="flex_idx_profile_phone">Phone Number</label></th>
                <td>
                    <input type="text" name="flex_idx_profile_phone" id="flex_idx_profile_phone"
                           value="<?php echo esc_attr(get_the_author_meta('flex_idx_profile_phone', $user->ID)); ?>"
                           class="regular-text"/><br/>
                    <span class="description">Please enter your Phone number.</span>
                </td>
            </tr>
            <tr>
                <th><label for="flex_idx_profile_address">Address</label></th>
                <td>
                    <input type="text" name="flex_idx_profile_address" id="flex_idx_profile_address"
                           value="<?php echo esc_attr(get_the_author_meta('flex_idx_profile_address', $user->ID)); ?>"
                           class="regular-text"/><br/>
                    <span class="description">Please enter your Address.</span>
                </td>
            </tr>
            <tr>
                <th><label for="flex_idx_profile_city">City</label></th>
                <td>
                    <input type="text" name="flex_idx_profile_city" id="flex_idx_profile_city"
                           value="<?php echo esc_attr(get_the_author_meta('flex_idx_profile_city', $user->ID)); ?>"
                           class="regular-text"/><br/>
                    <span class="description">Please enter your City.</span>
                </td>
            </tr>
            <tr>
                <th><label for="flex_idx_profile_state">State</label></th>
                <td>
                    <input type="text" name="flex_idx_profile_state" id="flex_idx_profile_state"
                           value="<?php echo esc_attr(get_the_author_meta('flex_idx_profile_state', $user->ID)); ?>"
                           class="regular-text"/><br/>
                    <span class="description">Please enter your State.</span>
                </td>
            </tr>
            <tr>
                <th><label for="flex_idx_profile_zip">Zip Code</label></th>
                <td>
                    <input type="text" name="flex_idx_profile_zip" id="flex_idx_profile_zip"
                           value="<?php echo esc_attr(get_the_author_meta('flex_idx_profile_zip', $user->ID)); ?>"
                           class="regular-text"/><br/>
                    <span class="description">Please enter your Zip Code.</span>
                </td>
            </tr>
        </table>
        <?php
    }
}
if (!function_exists('flex_idx_profile_save_fn')) {
    function flex_idx_profile_save_fn($user_id)
    {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
        update_usermeta($user_id, 'flex_idx_profile_phone', $_POST['flex_idx_profile_phone']);
        update_usermeta($user_id, 'flex_idx_profile_address', $_POST['flex_idx_profile_address']);
        update_usermeta($user_id, 'flex_idx_profile_city', $_POST['flex_idx_profile_city']);
        update_usermeta($user_id, 'flex_idx_profile_state', $_POST['flex_idx_profile_state']);
        update_usermeta($user_id, 'flex_idx_profile_zip', $_POST['flex_idx_profile_zip']);
    }
}
if (!function_exists('flex_idx_saved_search_url_params')) {
    function flex_idx_saved_search_url_params($search_url)
    {
        $query_string = parse_url($search_url, PHP_URL_QUERY);
        parse_str($query_string, $query_params);

        $labels = [];

        if (isset($query_params["price"]) && !empty($query_params["price"])) {
            $price_exp = explode("-", $query_params["price"]);

            if ((2 === count($price_exp)) && ("" !== $price_exp[1])) {
                $labels["price"] = sprintf('$%s - $%s', flex_idx_format_short_price_fn($price_exp[0]), flex_idx_format_short_price_fn($price_exp[1]));
            } else {
                $labels["price"] = sprintf('$%s - Any Price', flex_idx_format_short_price_fn($price_exp[0]));
            }
        } else {
            $labels["price"] = "Any Price";
        }

        if (isset($query_params["beds"]) && !empty($query_params["beds"])) {
            $beds_exp = explode("-", $query_params["beds"]);

            if ((2 === count($beds_exp)) && ("" !== $beds_exp[1])) {
                $labels["beds"] = sprintf('%s - %s Bed(s)', number_format($beds_exp[0]), number_format($beds_exp[1]));
            } else {
                $labels["beds"] = sprintf('%s - Any Bed', number_format($beds_exp[0]));
            }
        } else {
            $labels["beds"] = "Any Bed";
        }

        if (isset($query_params["baths"]) && !empty($query_params["baths"])) {
            $baths_exp = explode("-", $query_params["baths"]);

            if ((2 === count($baths_exp)) && ("" !== $baths_exp[1])) {
                $labels["baths"] = sprintf('%s - %s Bath(s)', number_format($baths_exp[0]), number_format($baths_exp[1]));
            } else {
                $labels["baths"] = sprintf('%s - Any Bath', number_format($baths_exp[0]));
            }
        } else {
            $labels["baths"] = "Any Bath";
        }

        if (isset($query_params["size"]) && !empty($query_params["size"])) {
            $size_exp = explode("-", $query_params["size"]);

            if ((2 === count($size_exp)) && ("" !== $size_exp[1])) {
                $labels["size"] = sprintf('%s - %s Sq.Ft.', number_format($size_exp[0]), number_format($size_exp[1]));
            } else {
                $labels["size"] = sprintf('%s - Any Size', number_format($size_exp[0]));
            }
        } else {
            $labels["size"] = "Any Size";
        }

        return $labels;

        /*
        global $flex_idx_info;
        $search_url = str_replace($flex_idx_info["pages"]["flex_idx_search"]["guid"], "", $search_url);
        $search_url_exp = explode('/', $search_url);
        $cities            = array();
        $features_qty      = 0;
        $price_range       = array('Any Price', 'Any Price');
        $short_price_range = array('Any Price', 'Any Price');
        $beds_range        = array('Any Bed', 'Any Bed');
        $baths_range       = array('Any Bath', 'Any Bath');
        $sqft_range        = array('Any Size', 'Any Size');
        for ($i = 0, $l = count($search_url_exp); $i < $l; $i++) {
            $parse_key_value = explode("-", $search_url_exp[$i]);
            if (count($parse_key_value) != 2) {
              continue;
            }
            list($key, $value) = $parse_key_value;
            $key               = strtolower($key);
            switch ($key) {
                case 'keywords':
                    $keywords_slug = urldecode($value);
                    $keywords_arr  = explode('~', $keywords_slug);
                    foreach ($keywords_arr as $keyword_item) {
                        $keyword_item_exp = explode('|', $keyword_item);
                        if ($keyword_item_exp[1] == 'city') {
                            $cities[] = $keyword_item_exp[0];
                        }
                    }
                    break;
                case 'range_price':
                    $range_price_exp = explode('~', $value);
                    $price_range[0] = '$' . number_format($range_price_exp[0]);
                    $price_range[1] = isset($range_price_exp[1]) ? '$' . number_format($range_price_exp[1]) : 'Any Price';
                    $short_price_range[0] = '$' . flex_idx_format_short_price_fn($range_price_exp[0]);
                    $short_price_range[1] = isset($range_price_exp[1]) ? '$' . flex_idx_format_short_price_fn($range_price_exp[1]) : 'Any Price';
                    break;
                case 'range_bed':
                    $range_bed_exp = explode('~', $value);
                    $beds_range[0] = (isset($range_bed_exp[0]) && $range_bed_exp[0] <= 5) ? number_format($range_bed_exp[0]) : 'Any Bed';
                    $beds_range[1] = (isset($range_bed_exp[1]) && $range_bed_exp[1] <= 5) ? number_format($range_bed_exp[1]) : 'Any Bed';
                    break;
                case 'range_bath':
                    $range_bath_exp = explode('~', $value);
                    $baths_range[0] = (isset($range_bath_exp[0]) && $range_bath_exp[0] <= 5) ? number_format($range_bath_exp[0]) : 'Any Bath';
                    $baths_range[1] = (isset($range_bath_exp[1]) && $range_bath_exp[1] <= 5) ? number_format($range_bath_exp[1]) : 'Any Bath';
                    break;
                case 'range_sqft':
                    $range_sqft_exp = explode('~', $value);
                    $sqft_range[0] = (isset($range_sqft_exp[0]) && $range_sqft_exp[0] <= 90000) ? number_format($range_sqft_exp[0]) : 'Any Size';
                    $sqft_range[1] = (isset($range_sqft_exp[1]) && $range_sqft_exp[1] <= 90000) ? number_format($range_sqft_exp[1]) : 'Any Size';
                    break;
                case 'features':
                    $features_exp = explode('~', $value);
                    $features_qty = count($features_exp);
                    break;
            }
        }
        return array(
            'cities'            => $cities,
            'price_range'       => $price_range,
            'short_price_range' => $short_price_range,
            'beds_range'        => $beds_range,
            'baths_range'       => $baths_range,
            'sqft_range'        => $sqft_range,
            'features_qty'      => $features_qty,
        );
        */
    }
}

if (!function_exists('flex_idx_format_short_price_fn')) {
    function flex_idx_format_short_price_fn($input)
    {
        $returnPrice = '';
        if ($input < 1000) {
            return $input;
        }
        if ($input < 10000) {
            $returnPrice = ceil($input / 100) / 10;
            return $returnPrice . 'K';
        } else {
            if ($input < 1000000) {
                $returnPrice = ceil($input / 1000);
                if ($returnPrice < 100) {
                    return substr($returnPrice, 0, 2) . 'K';
                }
                if ($returnPrice >= 1000) {
                    return '1M';
                }
                return $returnPrice . 'K';
            } else {
                if ($input < 10000000) {
                    $returnPrice = (ceil($input / 10000) / 100);
                } else {
                    $returnPrice = (ceil($input / 100000) / 10);
                }
            }
        }
        if (strpos($returnPrice, '.') != false) {
            $returnPrice = substr($returnPrice, 0, 4);
        }
        return $returnPrice . 'M';
    }
}
if (!function_exists('flex_lead_logout_xhr_fn')) {
    function flex_lead_logout_xhr_fn()
    {
        wp_send_json(array('success' => true, 'message' => 'log out done successfully.'));
        exit;
    }
}
if (!function_exists('flex_agent_format_phone_number')) {
    function flex_agent_format_phone_number($input)
    {
        if (empty($input)) {
            return '';
        }
        return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $input);
    }
}
if (!function_exists('idxboost_language_default_plugin')) {
    function idxboost_language_default_plugin($lang)
    {
        $flex_idx_info = flex_idx_get_info();
        if (array_key_exists('search', $flex_idx_info)) {
            if (array_key_exists('default_language', $flex_idx_info['search']))
                if (!empty($flex_idx_info['search']['default_language']))
                    $default_language = $flex_idx_info['search']['default_language'];
                else
                    $default_language = 'en';
            else
                $default_language = 'en';
        } else {
            $default_language = 'en';
        }
        if (!defined('IDXBOOST_DOMAIN_THEME_LANG')) {
            define('IDXBOOST_DOMAIN_THEME_LANG', 'idxboost');
        }

        add_action('after_setup_theme', function () {
            load_theme_textdomain(IDXBOOST_DOMAIN_THEME_LANG, FLEX_IDX_PATH . '/languages');
        });
        $text_language = '';
        $text_language = $default_language . '_' . strtoupper($default_language);
        return $text_language;
    }

    add_filter('locale', 'idxboost_language_default_plugin');
}

if (!function_exists('idxboost_front_page_template')) {

    function idxboost_front_page_template($template)
    {
        global $flex_idx_info;

        if (!empty($flex_idx_info['agent']['has_cms']) && $flex_idx_info['agent']['has_cms'] != false) {
            if (is_front_page()) {
                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_home_page.php')) {
                    return IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_home_page.php';
                } else {
                    return FLEX_IDX_PATH . '/views/shortcode/idxboost_home_page.php';
                }
            }
        }

        return $template;
    }

    add_filter('template_include', 'idxboost_front_page_template');
}


if (!function_exists('idxboost_get_header_dinamic')) {

    function idxboost_get_header_dinamic($name)
    {

        global $flex_idx_info, $post;

        if (!empty($flex_idx_info['agent']['has_cms']) && $flex_idx_info['agent']['has_cms'] != false) {

            $flex_idx_page_type = get_post_meta($post->ID, 'idx_page_type', true);

            if (is_front_page() || $flex_idx_page_type == 'landing') {
                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_header_dinamic_frontpage.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_header_dinamic_frontpage.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idxboost_header_dinamic_frontpage.php';
                }
            } else {
                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_header_dinamic.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_header_dinamic.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idxboost_header_dinamic.php';
                }
            }
        }
    }

    add_action('idx_dinamic_body', 'idxboost_get_header_dinamic', 100, 1);
}

if (!function_exists('idx_edit_post')) {
    function idx_edit_post($post_ID, $post)
    {
        $meta = get_post_meta($post_ID, 'idx_page_type', true);
        if ($meta == 'custom' || $meta == 'landing') {
            wp_remote_post(
                IDX_BOOST_SPW_BUILDER_SERVICE . '/api/update-page-fromWp',
                array(
                    'method' => 'POST',
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'body' => wp_json_encode(array(
                        'post_name' => $post->post_name,
                        "post_title" => $post->post_title,
                        "permalink" => get_permalink($post->ID),
                        "page_id" => get_post_meta($post_ID, 'idx_page_id')[0]
                    ))
                )
            );
        }
    }
}

if (!function_exists('hide_editor')) {
    function hide_editor()
    {
        // Get the Post ID.
        $post_id = ('POST' === $_SERVER['REQUEST_METHOD']) ? ($_POST['post_ID'] ?? null) : (isset($_GET['post']) ? $_GET['post'] : null);
        if (!isset($post_id)) return;

        // Get the name of the Page Template file.
        $meta = get_post_meta($post_id, 'idx_page_type', true);
        if ($meta == 'custom' || $meta == 'landing') {
            remove_post_type_support('page', 'editor');
        }
    }
}

if (!function_exists('idxboost_footer_header_dinamic')) {
    function idxboost_footer_header_dinamic($name)
    {
        global $flex_idx_info, $post;
        $flex_idx_page_type = get_post_meta($post->ID, 'idx_page_type', true);

        if (!empty($flex_idx_info['agent']['has_cms']) && $flex_idx_info['agent']['has_cms'] != false) {

            $show_footer = true;

            if (
                in_array($post->post_type, ["flex-idx-pages", "flex-landing-pages"]) ||
                is_front_page() ||
                $flex_idx_page_type == 'landing'
            ) {
                $type_filter = get_post_meta($post->ID, '_flex_id_page', true);
                $show_footer = false;

                if (!empty($type_filter) && !in_array($type_filter, ["flex_idx_search"])) {
                    $show_footer = true;
                }
            }

            if ($show_footer) {
                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_footer_dinamic.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_footer_dinamic.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idxboost_footer_dinamic.php';
                }
            }
        }
    }

    add_action('get_footer', 'idxboost_footer_header_dinamic', 100, 1);
}

if (!function_exists('update_seo')) {
    function update_seo($title, $description, $socialShareTitle, $socialShareImage)
    {
        echo '<title>' . $title . '</title>
              <meta name="description" content="' . $description . '" />
              <meta name="twitter:title" content="' . $title . '">
              <meta name="twitter:description" content="' . $description . '">
              <meta name="twitter:image" content="' . $socialShareImage . '">
              <meta property="og:title" content="' . $socialShareTitle . '" />
              <meta property="og:type" content="article" />
              <meta property="og:image" content="' . $socialShareImage . '" />
              <meta property="og:description" content="' . $description . '" />
              <meta property="og:site_name" content="' . $socialShareTitle . '" />';
    }
}

if (!function_exists('update_seo_default')) {
    function update_seo_default()
    {
        echo '<title>' . wp_title('|', 0, 'right') . get_bloginfo('name') . '</title>';
        if (get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true)) {
            echo '<meta name="description" content="' . get_bloginfo("description") . '">';
        }
    }
}

if (!function_exists('update_seo_all_page')) {
    function update_seo_all_page($title)
    {
        echo '<title>' . wp_title('|', 0, 'right') . $title . '</title>';
        if (get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true)) {
            echo '<meta name="description" content="' . get_bloginfo("description") . '">';
        }
    }
}

if (!function_exists("idxboost_integrations_head")) {
    function idxboost_integrations_head()
    {
        global $flex_idx_info;
        //Facebook Pixel
        if ($flex_idx_info['agent']['facebook_pixel'] != "") {
            echo "<script>!function(f,b,e,v,n,t,s)  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?  n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';  n.queue=[];t=b.createElement(e);t.async=!0;  t.src=v;s=b.getElementsByTagName(e)[0];  s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');  fbq('init', '" . $flex_idx_info['agent']['facebook_pixel'] . "');  fbq('track', 'PageView');</script><noscript><imgheight=\"1\"width=\"1\"style=\"display:none\"src=\"https://www.facebook.com/tr?id={your-pixel-id-goes-here}&ev=PageView&noscript=1\"/></noscript>";
        }

        //Stat Counter
        if ($flex_idx_info['agent']['stat_counter_security_id'] != "") {
            echo "<script type=\"text/javascript\">var sc_project=" . $flex_idx_info['agent']['stat_counter_project_id'] . "; var sc_invisible=1; var sc_security=" . $flex_idx_info['agent']['stat_counter_security_id'] . "; var sc_https=1; </script><script type=\"text/javascript\"src=\"https://www.statcounter.com/counter/counter.js\"async></script><noscript><div class=\"statcounter\"><a title=\"Web Analytics\"href=\"http://statcounter.com/\" target=\"_blank\"><imgclass=\"statcounter\"src=\"//c.statcounter.com/" . $flex_idx_info['agent']['stat_counter_project_id'] . "/0/" . $flex_idx_info['agent']['stat_counter_security_id'] . "/1/\" alt=\"WebAnalytics\"></a></div></noscript>";
        }
    }
}

if (!function_exists("custom_seo_page")) {
    function custom_seo_page()
    {
        global $post;
        global $flex_idx_info;
        global $wp;
        $wp_theme = wp_get_theme();
        $wp_request = $wp->request;

        if (
            "Builder CMS" == $wp_theme->name &&
            !empty($flex_idx_info['agent']['has_cms']) &&
            $flex_idx_info['agent']['has_cms'] != false
        ) {

            $metas = get_post_meta($post->ID, 'idx_page_type');
            $type_filter = get_post_meta($post->ID, '_flex_id_page', true);

            if (
                (!empty($metas) && ($metas[0] == 'custom' or $metas[0] == 'landing')) or
                is_home() or is_front_page() or
                ($post->post_type == 'flex-idx-pages' && $type_filter == "flex_idx_page_about") or
                ($post->post_type == 'flex-idx-pages' && $type_filter == "flex_idx_page_contact")
            ) {
                $page_type = '';
                $post_id = '';

                if ($metas && $metas[0] == 'custom') {
                    $page_type = 'custom';
                    $post_id = $post->ID;
                }

                if ($metas && $metas[0] == 'landing') {
                    $page_type = 'landing';
                    $post_id = $post->ID;
                }

                if (is_home() || is_front_page()) {
                    $page_type = 'home';
                }

                if ($post->post_type == 'flex-idx-pages' && $type_filter == "flex_idx_page_about") {
                    $page_type = 'about';
                }

                if ($post->post_type == 'flex-idx-pages' && $type_filter == "flex_idx_page_contact") {
                    $page_type = 'contact';
                }

                $response = wp_remote_post(
                    IDX_BOOST_SPW_BUILDER_SERVICE . '/api/get-seo',
                    array(
                        'method' => 'POST',
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'body' => wp_json_encode(array(
                            'registration_key' => get_option('idxboost_registration_key'),
                            "page_type" => $page_type,
                            "post_id" => $post_id
                        ))
                    )
                );

                $body = wp_remote_retrieve_body($response);
                $content = json_decode($body, true);

                if (!is_wp_error($response) or $content != NULL) {
                    // validar que se use el seo, sino usar seo por defecto
                    if ($content['cmsSeo'] == 1) {
                        update_seo($content['seo']['title'], $content['seo']['description'], $content['socialShare']['title'], $content['socialShare']['image']);
                    } else {
                        update_seo_default();
                    }
                } else {
                    update_seo_default();
                }
            } else {
                $response = wp_remote_post(
                    IDX_BOOST_SPW_BUILDER_SERVICE . '/api/get-seo',
                    array(
                        'method' => 'POST',
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'body' => wp_json_encode(array(
                            'registration_key' => get_option('idxboost_registration_key'),
                            "page_type" => 'home',
                            "post_id" => ''
                        ))
                    )
                );

                $body = wp_remote_retrieve_body($response);
                $content = json_decode($body, true);

                if (!is_wp_error($response) or $content != NULL) {
                    update_seo_all_page($content['seo']['title']);
                } else {
                    update_seo_default();
                }
            }
        } elseif ("Builder CMS" == $wp_theme->name) {
            update_seo_default();
        }
    }
}

if (!function_exists('idxboost_save_options_after_update')) {
    $options = array(
        'action' => 'update',
        'type' => 'plugin',
        'plugins' => array(0 => 'idxboost/idxboost.php')
    );

    function idxboost_save_options_after_update($upgrader_object, $options)
    {
        if ($options['action'] == 'update' && $options['type'] == 'plugin' && in_array('idxboost/idxboost.php', $options['plugins'])) {
            $data_parameters = [];
            if (function_exists('is_wpe')) {
                if (is_wpe() == 1) {
                    $data_parameters['idx_environment_site'] = 'production';
                } else {
                    $data_parameters['idx_environment_site'] = 'staging';
                }
            } else {
                $data_parameters['idx_environment_site'] = 'production';
            }
            //$data_parameters['idx_environment_site']='production';
            $data_parameters['idx_map_style'] = '';
            fc_idx_save_tools_admin($data_parameters);
        }
    }

    add_action('upgrader_process_complete', 'idxboost_save_options_after_update', 10, 2);
}

if (!function_exists("flex_idx_get_building_noscript_inventory")) {
    function flex_idx_get_building_noscript_inventory($result_data_collection = [], $head_property = 'Sale', $type_data = 'sale')
    { ?>
        <noscript>
            <?php
            $arrebed = [];
            foreach ($result_data_collection as $key => $value) {
                if (strlen(array_search($value['bed'], $arrebed)) == 0) {
                    $arrebed[] = $value['bed'];
                }
            }
            arsort($arrebed);
            array_unique($arrebed);
            ?>
            <?php $countar = 0;
            foreach ($arrebed as $keybed => $valbed) {
                $countar = $countar + 1; ?>
                <h2 class="title-thumbs"><?php
                    if ($valbed == 0) {
                        echo __('Studio', IDXBOOST_DOMAIN_THEME_LANG);
                    } else {
                        if ($type_data == 'for_rent') {
                            echo $valbed . __(' Bedroom Apartments ', IDXBOOST_DOMAIN_THEME_LANG) . $head_property . ' at ' . get_the_title();
                        } else {
                            echo $valbed . __(' Bedroom Condos ', IDXBOOST_DOMAIN_THEME_LANG) . $head_property . ' at ' . get_the_title();
                        }
                    }

                    ?></h2>
                <div class="tbl_properties_wrapper">
                    <table class="display" id="dataTable-pending-<?php echo $countar; ?>" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="dt-center sorting"><?php echo __('unit', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                            <th class="dt-center sorting class_asking_prince"><?php echo __('Asking Price', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                            <th class="dt-center sorting">% / $</th>
                            <th class="dt-center sorting"><?php echo __('Beds', IDXBOOST_DOMAIN_THEME_LANG); ?>
                                / <?php echo __('Baths', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                            <th class="dt-center sorting show-desktop"><?php echo __('Living Size', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                            <th class="dt-center sorting show-desktop"><?php echo __('Price', IDXBOOST_DOMAIN_THEME_LANG); ?>
                                / Sq.Ft.
                            </th>
                            <th class="dt-center sorting show-desktop"><?php echo __('Days on Market', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($result_data_collection as $key => $value) {
                            if ($value['bed'] == $valbed) { ?>
                                <tr class="flex-tbl-link"
                                    data-permalink="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $value['slug']; ?>">
                                    <td>
                                        <div class="unit propertie" data-mls="<?php echo $value['mls_num']; ?>">
                                            <button class="clidxboost-btn-check flex-favorite-btn">
                                                <span class="clidxboost-icon-check clidxboost-icon-check-list"></span>
                                            </button>
                                            <span><?php echo $value['unit']; ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="asking-number blue">
                                            $<?php echo number_format($value['price']); ?></div>
                                    </td>
                                    <td>
                                        <div class="porcentaje <?php if ($value['reduced'] !== '' && $value['reduced'] < 0) : ?>red<?php elseif ($value['reduced'] !== '' && $value['reduced'] >= 0) : ?>green<?php else : ?>black<?php endif; ?>"><?php if (strlen($value['reduced']) != 0) echo $value['reduced'] . '%';
                                            else echo 'N/A'; ?></div>
                                    </td>
                                    <td>
                                        <div class="beds"><?php echo $value['bed']; ?> / <?php echo $value['bath']; ?>
                                            / <?php echo $value['baths_half']; ?></div>
                                    </td>
                                    <td class="table-beds show-desktop">
                                        <div class="beds"><?php echo $value['sqft']; ?> Sq.Ft.</div>
                                    </td>
                                    <td class="table-beds show-desktop">
                                        <div class="price">
                                            $<?php echo ($value['sqft'] > 0) ? number_format($value['price'] / $value['sqft']) : 0; ?></div>
                                    </td>
                                    <td class="table-beds show-desktop">
                                        <div class="dayson"><?php echo $value['days_market']; ?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </noscript>

        <?php
    }
}

if (!function_exists("idx_autologin_authenticate")) {
    function idx_autologin_authenticate()
    {
        if (strpos($_SERVER["REQUEST_URI"], '/autologin?token=') !== false) {
            $publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
ehde/zUxo6UvS7UrBQIDAQAB
-----END PUBLIC KEY-----
EOD;
            require "JWT.php";
            $token = $_GET['token'];
            try {
                $decoded = JWT::decode($token, $publicKey, array('RS256'));
                $decoded_array = (array)$decoded;
                $page = $decoded_array['page'];
                $userToLogin = get_user_by('email', $decoded_array['email']);
                $role = '';
                if ($userToLogin) {
                    wp_set_current_user($userToLogin->ID);
                    wp_set_auth_cookie($userToLogin->ID, false);
                    do_action('wp_login', $userToLogin->name, $userToLogin);
                    if (in_array('administrator', $userToLogin->roles)) {
                        $role = 'admin';
                    } else {
                        $role = 'editor';
                    }
                } else {
                    $editors = get_users(array(
                        'role__in' => 'editor',
                        'fields' => array('user_login'),
                    ));

                    if (!empty($editors)) {
                        $userToLogin = get_user_by('login', $editors[0]->user_login);
                        if ($userToLogin) {
                            $role = 'editor';
                            wp_set_current_user($userToLogin->ID);
                            wp_set_auth_cookie($userToLogin->ID, false);
                            do_action('wp_login', $userToLogin->name, $userToLogin);
                        }
                    } else {

                        $admins = get_users(array(
                            'role__in' => 'administrator',
                            'fields' => array('user_login'),
                        ));
                        if (!empty($admins)) {
                            $userToLogin = get_user_by('login', $admins[0]->user_login);
                            if ($userToLogin) {
                                $role = 'admin';
                                wp_set_current_user($userToLogin->ID);
                                wp_set_auth_cookie($userToLogin->ID, false);
                                do_action('wp_login', $userToLogin->name, $userToLogin);
                            }
                        }
                    }
                }
                if ($page == 'home') wp_redirect(home_url());
                if ($page == 'admin' && $role == 'editor') {
                    wp_redirect(admin_url() . '?page=flex-idx-editor');
                }
                if ($page == 'admin' && $role == 'admin') {
                    wp_redirect(admin_url() . '?page=flex-idx');
                }
                if ($page == 'admin' && $role == '') {
                    wp_redirect(home_url());
                }
                exit();
            } catch (Exception $ex) {
                wp_redirect(home_url());
                exit();
            }
        }
    }
}
