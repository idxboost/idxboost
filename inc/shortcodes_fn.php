<?php

if (!function_exists('idxboost_lead_activities_sc')) {
    function idxboost_lead_activities_sc($atts, $content = null) {
        global $flex_idx_lead, $flex_idx_info;

        ob_start();

		if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_history_menu.php')) {
			include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_history_menu.php';
		} else {
			include FLEX_IDX_PATH . '/views/shortcode/flex_idx_history_menu.php';
		}

        return ob_get_clean();
    }

    add_shortcode('idxboost_lead_activities', 'idxboost_lead_activities_sc');
}

if (!function_exists('idxboost_quick_search_sc'))
{
    function idxboost_quick_search_sc($atts, $content = null) {
        global $flex_idx_info;

        wp_enqueue_style("idxboost-quick-search-v2-theme");
        wp_enqueue_script("idxboost-quick-search-v2");

        ob_start();

		if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_quick_search.php')) {
			include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_quick_search.php';
		} else {
			include FLEX_IDX_PATH . '/views/shortcode/idxboost_quick_search.php';
		}

        return ob_get_clean();
    }

    add_shortcode("idxboost_quick_search", "idxboost_quick_search_sc");
}

if (!function_exists('ib_crm_listings_collection_sc')) {
    function ib_crm_listings_collection_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;
        $user_account_id  = isset($flex_idx_info['agent']['user_id']) ? $flex_idx_info['agent']['user_id'] : '0';

        $atts = shortcode_atts(array(
            'order'   => 'price-asc',
            'tag'     => 'default',
            'limit'     => 'default',
            'limit'     => '20',
            'column'     => 'two',
            'mode' => 'default',
            "slider_item" => "4",
            "slider_play" => "0",
            "slider_speed" => "5000",            
            'title'   => ''
        ), $atts);
        
        $idxboost_registration_key = get_option('idxboost_registration_key');
        
        wp_localize_script('flex-idx-single-property-collection-js', 'ib_property_collection',
            [
                'order' => $atts['order'],
                'tag' => $atts['tag'],
                'limit' => $atts['limit'],
                'mode' => $atts['mode'],
                'ajaxlist' => FLEX_IDX_SINGLE_PROPERTY_COLLECTION,
                'ajaxUrl'        => admin_url('admin-ajax.php'),
                'ajaxgetProperty' => FLEX_IDX_GET_SINGLE_PROPERTY,
                'ajaxSetting' => FLEX_IDX_SINGLE_PROPERTY_COLLECTION_SETTING,
                'rg' => $idxboost_registration_key
            ]
        );


        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data.</div>';
        }
        wp_enqueue_script('flex-idx-single-property-collection-js');
        wp_enqueue_style('flex-idx-single-property-collection-css');
        ob_start();

        if($atts['mode'] == 'slider'){
            if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/slider_single_property_collection.php')) {
                include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/slider_single_property_collection.php';
            } else {
                include FLEX_IDX_PATH . '/views/shortcode/slider_single_property_collection.php';
            }
        }else{
            if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/page_single_property_collection.php')) {
                include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/page_single_property_collection.php';
            } else {
                include FLEX_IDX_PATH . '/views/shortcode/page_single_property_collection.php';
            }            
        }


        return ob_get_clean();
    }

    add_shortcode('list_property_collection', 'ib_crm_listings_collection_sc');
}

if (!function_exists('ib_crm_listings_collection_slider_sc')) {
    function ib_crm_listings_collection_slider_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;
        $atts = shortcode_atts(array(
            'order'   => 'list',
            'limit'     => 'default',
            'column'     => 'four',
            'link_more' => '',
            'title'   => ''
        ), $atts);
        
        wp_localize_script('slider-single-property-collection-js', 'ib_property_collection_slider',
            [
                'order' => $atts['order'],
                'limit' => $atts['limit'],
                'ajaxlist' => FLEX_IDX_SINGLE_PROPERTY_COLLECTION,
            ]
        );


        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data.</div>';
        }
        wp_enqueue_script('flex-idx-single-property-collection-js');
        wp_enqueue_style('flex-idx-single-property-collection-css');
        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/slider_single_property_collection.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/slider_single_property_collection.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/slider_single_property_collection.php';
        }
        return ob_get_clean();
    }

    add_shortcode('slider_property_collection', 'ib_crm_listings_collection_slider_sc');
}

if (!function_exists("idxboost_dinamic_menu_sc")) {
    function idxboost_dinamic_menu_sc($atts, $content = null)
    {
        $atts = shortcode_atts(array(
            'registration_key' => ""
        ), $atts);

        wp_enqueue_script("iboost-buyers-sellers-js");

        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_menu_dinamic.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_menu_dinamic.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/idxboost_menu_dinamic.php';
        }

        return ob_get_clean();
    }

    add_shortcode("idxboost_dinamic_menu", "idxboost_dinamic_menu_sc");
}

if (!function_exists("idxboost_dinamic_menu_mobile_sc")) {
    function idxboost_dinamic_menu_mobile_sc($atts, $content = null)
    {
        $atts = shortcode_atts(array(
            'registration_key' => ""
        ), $atts);

        wp_enqueue_script("iboost-buyers-sellers-js");

        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_menu_dinamic_mobile.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_menu_dinamic_mobile.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/idxboost_menu_dinamic_mobile.php';
        }

        return ob_get_clean();
    }

    add_shortcode("idxboost_dinamic_menu_mobile", "idxboost_dinamic_menu_mobile_sc");
}


if (!function_exists("idxboost_social_network_dinamic_header_sc")) {
    function idxboost_social_network_dinamic_header_sc($atts, $content = null)
    {
        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_social_network_dinamic_header.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_social_network_dinamic_header.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/idxboost_social_network_dinamic_header.php';
        }

        return ob_get_clean();
    }

    add_shortcode("idxboost_social_network_dinamic_header", "idxboost_social_network_dinamic_header_sc");
}

if (!function_exists("idxboost_dinamic_credential_lead_dinamic_sc")) {
    function idxboost_dinamic_credential_lead_dinamic_sc($atts, $content = null)
    {
        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_dinamic_credential_lead_dinamic.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_dinamic_credential_lead_dinamic.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/idxboost_dinamic_credential_lead_dinamic.php';
        }

        return ob_get_clean();
    }

    add_shortcode("idxboost_dinamic_credential_lead_dinamic", "idxboost_dinamic_credential_lead_dinamic_sc");
}

if (!function_exists("idxboost_social_network_dinamic_footer_sc")) {
    function idxboost_social_network_dinamic_footer_sc($atts, $content = null)
    {
        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_social_network_dinamic_footer.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_social_network_dinamic_footer.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/idxboost_social_network_dinamic_footer.php';
        }

        return ob_get_clean();
    }

    add_shortcode("idxboost_social_network_dinamic_footer", "idxboost_social_network_dinamic_footer_sc");
}


if (!function_exists('idxboost_about_page_sc'))
{
    function idxboost_about_page_sc($atts, $content = null) {
        global $flex_idx_info;

        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_about_page.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_about_page.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/idxboost_about_page.php';
        }

        return ob_get_clean();
    }

    add_shortcode("idxboost_about_page", "idxboost_about_page_sc");
}


if (!function_exists('idxboost_team_page_sc'))
{
    function idxboost_team_page_sc($atts, $content = null) {
        global $flex_idx_info;

        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_team_page.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_team_page.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/idxboost_team_page.php';
        }

        return ob_get_clean();
    }

    add_shortcode("idxboost_team_page", "idxboost_team_page_sc");
}


if (!function_exists('idxboost_contact_page_sc'))
{
    function idxboost_contact_page_sc($atts, $content = null) {
        global $flex_idx_info;

        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_contact_page.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_contact_page.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/idxboost_contact_page.php';
        }

        return ob_get_clean();
    }

    add_shortcode("idxboost_contact_page", "idxboost_contact_page_sc");
}














if (!function_exists('idxboost_building_inventory_expand_sc')) {
    function idxboost_building_inventory_expand_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'building_id' => '',
            'type'        => 'all',
            'title'        => '',
            'sub_title'        => '',
            'button_title' => 'show',
            'mode'        => 'default',
            'load'        => 'default',
            'limit'        => 'default',
            'view'        => 'grid',
        ), $atts);

        $type_view=$atts['type'];
        $type_view_default=$atts['view'];

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $atts['building_id'],
            'access_token'     => $access_token,
            'limit'        => $atts['limit'],
            'mode_view'        => $atts['mode'],
            'flex_credentials' => $flex_lead_credentials
        );

        if ($atts['button_title']=='hide') {
            $text_button_style='style="display: none;"';
        }
        
        wp_enqueue_style('flex-idx-filter-pages-css');

        wp_localize_script('flex-idx-building-inventory-js', 'ib_building_inventory', ['param'=>$sendParams,'load_item'=> "ajax"] );

        add_action('wp_footer', 'ib_tables_building_collection');

        /*only show in no script*/
        $result_data_collection_get=get_feed_file_building_history_building_xhr_fn($atts['building_id']);
        if (!empty($result_data_collection_get)) {
            $result_data_collection=json_decode($result_data_collection_get,true);
        }
        /*only show in no script*/

        $search_params = $flex_idx_info['search'];

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';

        ob_start();

            if($atts['mode']=='thumb'){
                include FLEX_IDX_PATH . '/views/shortcode/idxboost_building_collection_v2.php';
            }else{
                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_collection_v2.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_collection_v2.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idxboost_building_collection_v2.php';
                }
            }

        return ob_get_clean();
    }

    add_shortcode('building_inventory_expand', 'idxboost_building_inventory_expand_sc');
}


if (!function_exists('ib_search_box_sc')) {
    function ib_search_box_sc($atts, $content = null) {
        global $flex_idx_info;

        $atts = shortcode_atts([
            "type" => ""
        ], $atts);

        $cities = $flex_idx_info['search']['cities'];

        wp_enqueue_script("ib-search-box");
        ob_start();

        switch($atts["type"]) {
            case "condo":
?>
<form method="post" class="ib-search-box-form">
<h3 class="ib-title">Search Condos</h3>
<input type="hidden" name="type" value="condo">
<label for="c_sale"><input type="radio" name="for" value="sale" id="c_sale" checked><span></span>FOR SALE</label>
<label for="c_rent"><input type="radio" name="for" value="rent" id="c_rent"><span></span>FOR RENT</label>
<select name="city">
<option value="" selected>Search by City</option>
<?php foreach($cities as $city): ?>
<option value="<?php echo $city["name"]; ?>"><?php echo $city["name"]; ?></option>
<?php endforeach; ?>
</select>
<button type="submit">Search</button>
</form>
<?php
            break;
            case "house":
?>
<form method="post" class="ib-search-box-form">
<h3 class="ib-title">Search Homes</h3>
<input type="hidden" name="type" value="house">
<label for="h_sale"><input type="radio" name="for" value="sale" id="h_sale" checked><span></span>FOR SALE</label>
<label for="h_rent"><input type="radio" name="for" value="rent" id="h_rent"><span></span>FOR RENT</label>
<select name="city">
<option value="" selected>Search by City</option>
<?php foreach($cities as $city): ?>
<option value="<?php echo $city["name"]; ?>"><?php echo $city["name"]; ?></option>
<?php endforeach; ?>
</select>
<button type="submit">Search</button>
</form>
<?php
            break;
        }
        

        return ob_get_clean();
    }

    add_shortcode("ib_search_box", "ib_search_box_sc");
}

if (!function_exists("idxboost_buyers_form_sc")) {
    function idxboost_buyers_form_sc() {
        wp_enqueue_script("iboost-buyers-sellers-js");

        ob_start();

		if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_buyers_form.php')) {
			include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_buyers_form.php';
		} else {
			include FLEX_IDX_PATH . '/views/shortcode/idxboost_buyers_form.php';
		}

        return ob_get_clean();
    }

    add_shortcode("idxboost_buyers_form", "idxboost_buyers_form_sc");
}

if (!function_exists("idxboost_rentals_form_sc")) {
    function idxboost_rentals_form_sc() {
        wp_enqueue_script("iboost-buyers-sellers-js");

        ob_start();

		if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_rentals_form.php')) {
			include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_rentals_form.php';
		} else {
			include FLEX_IDX_PATH . '/views/shortcode/idxboost_rentals_form.php';
		}

        return ob_get_clean();
    }

    add_shortcode("idxboost_rentals_form", "idxboost_rentals_form_sc");
}

if (!function_exists("idxboost_sellers_form_sc")) {
    function idxboost_sellers_form_sc() {
        wp_enqueue_script("iboost-buyers-sellers-js");
        //wp_enqueue_script("iboost-autocomplete-seller-js");

        ob_start();

		if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_sellers_form.php')) {
			include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_sellers_form.php';
		} else {
			include FLEX_IDX_PATH . '/views/shortcode/idxboost_sellers_form.php';
		}

        return ob_get_clean();
    }

    add_shortcode("idxboost_sellers_form", "idxboost_sellers_form_sc");
}

// endpoint for commercial search
if (!function_exists('ib_commercial_search_sc')) {
    function ib_commercial_search_sc($atts, $content = null) {
        global $flex_idx_info;

        // echo '<pre>';
        // print_r($flex_idx_info["commercial_types"]);
        // echo '</pre>';
        // exit;

        ob_start();

        wp_enqueue_script('flex-idx-search-commercial-v2');

		if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_commercial_search.php')) {
			include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_commercial_search.php';
		} else {
			include FLEX_IDX_PATH . '/views/shortcode/flex_idx_commercial_search.php';
		}

        return ob_get_clean();
    }

    add_shortcode("ib_commercial_search", "ib_commercial_search_sc");
}

// endpoint for search v2
if (!function_exists('ib_search_sc')) {
    function ib_search_sc($atts, $content = null) {
        global $flex_idx_info;

        ob_start();

        // wp_enqueue_style('flex-idx-search-filter-css');
        wp_enqueue_script('flex-idx-search-filter-v2');

		if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search.php')) {
			include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search.php';
		} else {
			include FLEX_IDX_PATH . '/views/shortcode/flex_idx_search.php';
		}

		return ob_get_clean();
    }

    add_shortcode('ib_search', 'ib_search_sc');
}

if (!function_exists('ib_search_filter_sc')) {
    function ib_search_filter_sc($atts, $content = null) {
        global $flex_idx_info;

        $atts = shortcode_atts(array(
            'id' => '',
            'is_commercial' => '0',
            'oh' => '0',
            'agent_id' => '',
            'office_id' => '',
            'mode' => 'default',
            'link' => '',
            'title' => '',
            'name_button' => '',
            'slider_items' => '4'
        ), $atts);

        ob_start();

        // wp_enqueue_style('flex-idx-search-filter-css');

        if (isset($atts["is_commercial"]) && (1 == $atts["is_commercial"])) {
            wp_enqueue_script('flex-idx-search-commercial-filter');

            if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search_commercial_filter.php')) {
                include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search_commercial_filter.php';
            } else {
                include FLEX_IDX_PATH . '/views/shortcode/flex_idx_search_commercial_filter.php';
            }
        } else {
            wp_enqueue_script('flex-idx-search-filter');

            if ('slider' == $atts['mode']) {
                // Permite validar si el shortcode se ejecuta en modo slider, 
                // para no agregar la clase ms-hidden-ovf en el body
                wp_localize_script('flex-idx-search-filter', 'ib_search_filter_extra', [
                    'mode' => "slider"
                    ]
                );

                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search_filter_slider.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search_filter_slider.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/flex_idx_search_filter_slider.php';
                }
            } else {
                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search_filter.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search_filter.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/flex_idx_search_filter.php';
                }
            }
        }

		return ob_get_clean();
    }

    add_shortcode('ib_search_filter', 'ib_search_filter_sc');
}

if (!function_exists('ib_mini_search_sc'))
{
    function ib_mini_search_sc($atts, $content = null) {
        global $flex_idx_info,$wpdb;
        $atts = shortcode_atts(array(
            'template' => 'default'
        ), $atts);


        if ($atts['template']=='search_condos') {
            $loop_building = $wpdb->get_results("SELECT post.ID,post.post_title,post.post_name,meta.meta_value as top
                    FROM {$wpdb->posts} post
                left join {$wpdb->postmeta} meta on meta.post_id=post.ID and meta.meta_key='idx_building_top' and meta.meta_value = '1'
                WHERE post_type='flex-idx-building' and post_status='publish' order by post.post_title ASC;",ARRAY_A);   

            $object_building=get_post_type_object('flex-idx-building');
            $path_building=$object_building->rewrite['slug'];

            $list_top_building = array_filter($loop_building,function($item){ return $item['top']=='1'; } );
            
            wp_enqueue_script('idx-mini-search-new');
            if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_quick_search_new.php')) {
                include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_quick_search_new.php';
            } else {
                include FLEX_IDX_PATH . '/views/shortcode/idxboost_quick_search_new.php';
            }            
        }else{
            wp_enqueue_script('flex-mini-search');
            if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_quick_search.php')) {
                include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_quick_search.php';
            } else {
                include FLEX_IDX_PATH . '/views/shortcode/idxboost_quick_search.php';
            }            
        }

        ob_start();

        return ob_get_clean();
    }

    add_shortcode('ib_mini_search', 'ib_mini_search_sc');
}

if (!function_exists('ib_account_links_sc'))
{
	function ib_account_links_sc($atts, $content = null) {
		global $flex_idx_lead;

    $my_flex_pages = flex_user_list_pages();

		ob_start();

		if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_accounts_links.php')) {
			include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_accounts_links.php';
		} else {
			include FLEX_IDX_PATH . '/views/shortcode/flex_idx_accounts_links.php';
		}

		return ob_get_clean();
	}

	add_shortcode('ib_account_links', 'ib_account_links_sc');
}

if (!function_exists('flex_idx_terms_conditions_sc')) {
    function flex_idx_terms_conditions_sc($atts, $content = null)
    {
        global $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_TERMS_CONDITIONS);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

       ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost-terms-of-service.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost-terms-of-service.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/idxboost-terms-of-service.php';
				}

        return ob_get_clean();
    }

    add_shortcode('idxboost_terms_conditions', 'flex_idx_terms_conditions_sc');
}


if (!function_exists('flex_idx_accesibility_sc')) {
    function flex_idx_accesibility_sc($atts, $content = null)
    {
        global $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_TERMS_CONDITIONS);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

       ob_start();

                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost-accesibility.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost-accesibility.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idxboost-accesibility.php';
                }

        return ob_get_clean();
    }

    add_shortcode('idxboost_accesibility', 'flex_idx_accesibility_sc');
}



if (!function_exists('flex_idx_buildings_sc')) {
    function flex_idx_buildings_sc($atts, $content = null)
    {
        global $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        wp_enqueue_style('flex-idx-buildings');
        wp_enqueue_script('flex-idx-buildings-js');

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials,
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDINGS_LIST);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_buildings.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_buildings.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_buildings.php';
				}

        return ob_get_clean();
    }

    add_shortcode('flex_idx_buildings', 'flex_idx_buildings_sc');
}

if (!function_exists('idx_buildind_collection_history_sc')) {
    function idx_buildind_collection_history_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'building_id' => '',
            'mode'        => 'count',
        ), $atts);

        $path_feed = FLEX_IDX_PATH.'feed/';
        $building_id=md5($atts['building_id']);
        $post_building=$path_feed.'condo_'.$building_id.'.json';
        $date_now=date_create(date("Y-m-d H:i:s"));
        $date_file=date_create(date("Y-m-d H:i:s",filemtime($post_building)));
        $diff_file=date_diff($date_now,$date_file);

        if (!file_exists($post_building)) {
            idxboost_history_building_xhr_fn($atts['building_id']);
        }else{
            if ($diff_file->format("%a")>0) {
                idxboost_history_building_xhr_fn($atts['building_id']);
            }
        }

        $result_data=get_feed_file_building_history_building_xhr_fn($atts['building_id']);
        $result_data=json_decode($result_data,true);

        $args = array(
            'post_type'  => 'flex-idx-building',
            'meta_query' => array(
                array(
                    'key'     => '_flex_building_page_id',
                    'value'   => $atts['building_id'],
                    'compare' => '='
                )
            )
        );

        $the_query = new WP_Query( $args );
        $link_building='';
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $link_building=get_the_permalink();
            }
        }
        wp_reset_postdata();

        ob_start();

        if ($atts['mode']=='count') {
					if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/history_building_file_count.php')) {
						include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/history_building_file_count.php';
					} else {
						include FLEX_IDX_PATH . '/views/shortcode/history_building_file_count.php';
					}
        }else if ($atts['mode']=='inventary'){
					if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_collection_history.php')) {
						include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_collection_history.php';
					} else {
						include FLEX_IDX_PATH . '/views/shortcode/idxboost_building_collection_history.php';
					}
        }

        return ob_get_clean();
    }

    add_shortcode('idx_buildind_collection_history', 'idx_buildind_collection_history_sc');
}

if (!function_exists('flex_idx_search_sc')) {
    function flex_idx_search_sc($atts, $content = null)
    {
        global $wp, $wpdb, $flex_idx_info;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams_count = array(
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $chcanti = curl_init();

        curl_setopt($chcanti, CURLOPT_URL, FLEX_IDX_API_FAVORITES_LIST);
        curl_setopt($chcanti, CURLOPT_POST, 1);
        curl_setopt($chcanti, CURLOPT_POSTFIELDS, http_build_query($sendParams_count));
        curl_setopt($chcanti, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chcanti, CURLOPT_REFERER, ib_get_http_referer());

        $server_output_canti = curl_exec($chcanti);
        curl_close($chcanti);

        $response_canti = json_decode($server_output_canti, true);

        $wp_request_exp = explode('/', $wp->request);

        $search_query  = array();
        $search_slug   = array();

        $page_name     = isset($wp_request_exp[0]) ? $wp_request_exp[0] : 'search';
        $property_type = isset($wp_request_exp[1]) ? $wp_request_exp[1] : '';

        $search_params = $flex_idx_info['search'];

        if ($property_type == '') {
            // $property_type_slug = 'residential';
            $default_property_types = array();

            foreach ($search_params['property_types'] as $ptype) {
                $default_property_types[] = $ptype['value'];
            }

						/*$default_property_types = array_filter($default_property_types, function($value) {
							return is_numeric($value);
						});*/

            $property_type_slug = implode('|', $default_property_types);
            $property_type_arr  = $default_property_types;
            $is_rental = 0;
        } else {
            $property_type_exp  = explode('-', $property_type);
            $property_type_slug = '';
            $property_type_arr  = array();

            switch ($property_type_exp[0]) {
                case 'SingleFamilyHomes':
                    // case '2':
                    $property_type_slug = '2';
                    $property_type_arr  = array(2);
                    break;
                case 'condos':
                    // case '1':
                    $property_type_slug = '1';
                    $property_type_arr  = array(1);
                    break;
								case 'townhouses':
										$property_type_slug = 'tw';
										$property_type_arr  = array('tw');
										break;
                case 'residential':
                default:
                    $default_property_types = array();

                    foreach ($search_params['property_types'] as $ptype) {
                        $default_property_types[] = $ptype['value'];
                    }

										/*$default_property_types = array_filter($default_property_types, function($value) {
											return is_numeric($value);
										});*/

                    $property_type_slug = implode('|', $default_property_types);
                    $property_type_arr  = $default_property_types;
                    break;
            }

            $is_rental = $property_type_exp[1] == 'for~sale' ? 0 : 1;
        }

        $keywords_list   = array();
        $keywords_cities = array();
        // $keywords_slug   = '';

        $parking    = '--';
        $water_desc = '--';

        $features = array();

        $living_area_min          = '--';
        $living_area_max          = '--';
        $living_area_input_labels = array('0 SF', 'Any Size');

        $lot_size_min          = '--';
        $lot_size_max          = '--';
        $lot_size_input_labels = array('0 SF', 'Any Size');

        $min_bath = '--';
        $max_bath = '--';

        $min_bed = '--';
        $max_bed = '--';

        $min_year = '--';
        $max_year = '--';

        $min_price_sale          = '--';
        $max_price_sale          = '--';
        $price_sale_input_labels = array('$0', 'Any Price');

        $min_price_rent          = '--';
        $max_price_rent          = '--';
        $price_rent_input_labels = array('$0', 'Any Price');

        $order        = $flex_idx_info['search']['default_sort'];
        $default_view = $flex_idx_info['search']['default_view'];

        $page = 1;
				$board_id=$flex_idx_info['board_id'];

				$default_center = '';
				$default_zoom = '';

        for ($i = 2; $i < count($wp_request_exp); $i++) {
            $param = $wp_request_exp[$i];

            list($key, $value) = explode('-', $param);
            $key               = strtolower($key);

            switch ($key) {
							case 'coords':
									$default_coords = str_replace(array("coords-@", "z"), array("", ""), $param);
									$default_coords_exp = explode(",", $default_coords);
									$default_center = sprintf("%s %s", $default_coords_exp[0], $default_coords_exp[1]);
									$default_zoom = $default_coords_exp[2];
								break;
							case 'polygon':
									$polygon_token = $value;
									break;
                case 'keywords':
                    $keyword_exp = explode('|', urldecode($value));

                    if (count($keyword_exp) === 2) {
                        // OK
                        $keyword_value = $keyword_exp[0];
                        if ($keyword_exp[1] == 'mls') {
                            $keyword_type = strtoupper($keyword_exp[1]);
                        } else {
                            $keyword_type = ucfirst($keyword_exp[1]);
                        }

                        $keyword_label = $keyword_value . ' (' . $keyword_type . ')';
                        $keywords_slug = $keyword_exp[0] . '|' . $keyword_type;
                    } else {
                        $keyword_label = '';
                        $keywords_slug = '';
                    }

                    break;
                case 'range_price':
                    $range_price     = str_replace('range_price-', '', $param);
                    $range_price_exp = explode('~', $range_price);

                    if ($is_rental == 0) {
                        // for sale
                        if (count($range_price_exp) == 2) {
                            $min_price_sale = ($range_price_exp[0] == 0) ? '--' : $range_price_exp[0];
                            $max_price_sale = $range_price_exp[1];
                        } else {
                            $min_price_sale = $range_price_exp[0];
                            $max_price_sale = '--';
                        }

                        if ($range_price_exp[0] == 0) {
                            $price_sale_input_labels[0] = '$0';
                        } else if (!is_numeric($range_price_exp[0])) {
                            $price_sale_input_labels[0] = 'Any Price';
                        } else {
                            $price_sale_input_labels[0] = '$' . number_format($range_price_exp[0]);
                        }

                        if (!isset($range_price_exp[1])) {
                            $price_sale_input_labels[1] = 'Any Price';
                        } else {
                            $price_sale_input_labels[1] = '$' . number_format($range_price_exp[1]);
                        }
                    } else {
                        // for rent
                        if (count($range_price_exp) == 2) {
                            $min_price_rent = ($range_price_exp[0] == 0) ? '--' : $range_price_exp[0];
                            $max_price_rent = $range_price_exp[1];
                        } else {
                            $min_price_rent = $range_price_exp[0];
                            $max_price_rent = '--';
                        }

                        if ($range_price_exp[0] == 0) {
                            $price_rent_input_labels[0] = '$0';
                        } else if (!is_numeric($range_price_exp[0])) {
                            $price_rent_input_labels[0] = 'Any Price';
                        } else {
                            $price_rent_input_labels[0] = '$' . number_format($range_price_exp[0]);
                        }

                        if (!isset($range_price_exp[1])) {
                            $price_rent_input_labels[1] = 'Any Price';
                        } else {
                            $price_rent_input_labels[1] = '$' . number_format($range_price_exp[1]);
                        }
                    }
                    break;
                case 'range_bed':
                    $range_bed     = str_replace('range_bed-', '', $param);
                    $range_bed_exp = explode('~', $range_bed);

                    if (count($range_bed_exp) == 2) {
                        $min_bed = ($range_bed_exp[0] == 0) ? '--' : $range_bed_exp[0];
                        $max_bed = $range_bed_exp[1];
                    } else {
                        $min_bed = $range_bed_exp[0];
                        $max_bed = '--';
                    }
                    break;
                case 'range_bath':
                    $range_bath     = str_replace('range_bath-', '', $param);
                    $range_bath_exp = explode('~', $range_bath);

                    if (count($range_bath_exp) == 2) {
                        $min_bath = ($range_bath_exp[0] == 0) ? '--' : $range_bath_exp[0];
                        $max_bath = $range_bath_exp[1];
                    } else {
                        $min_bath = $range_bath_exp[0];
                        $max_bath = '--';
                    }
                case 'range_sqft':
                    $range_sqft     = str_replace('range_sqft-', '', $param);
                    $range_sqft_exp = explode('~', $range_sqft);

                    if (count($range_sqft_exp) == 2) {
                        $living_area_min = ($range_sqft_exp[0] == 0) ? '--' : $range_sqft_exp[0];
                        $living_area_max = $range_sqft_exp[1];
                    } else {
                        $living_area_min = $range_sqft_exp[0];
                        $living_area_max = '--';
                    }

                    if ($range_sqft_exp[0] == 0) {
                        $living_area_input_labels[0] = '0 SF';
                    } else if (!is_numeric($range_sqft_exp[0])) {
                        $living_area_input_labels[0] = 'Any Size';
                    } else {
                        $living_area_input_labels[0] = number_format($range_sqft_exp[0]) . ' SF';
                    }

                    if (!isset($range_sqft_exp[1])) {
                        $living_area_input_labels[1] = 'Any Size';
                    } else {
                        $living_area_input_labels[1] = number_format($range_sqft_exp[1]) . ' SF';
                    }

                    break;
                case 'range_lot_size':
                    $range_lot_size     = str_replace('range_lot_size-', '', $param);
                    $range_lot_size_exp = explode('~', $range_lot_size);

                    if (count($range_lot_size_exp) == 2) {
                        $lot_size_min = ($range_lot_size_exp[0] == 0) ? '--' : $range_lot_size_exp[0];
                        $lot_size_max = $range_lot_size_exp[1];
                    } else {
                        $lot_size_min = $range_lot_size_exp[0];
                        $lot_size_max = '--';
                    }

                    if ($range_lot_size_exp[0] == 0) {
                        $lot_size_input_labels[0] = '0 SF';
                    } else if (!is_numeric($range_lot_size_exp[0])) {
                        $lot_size_input_labels[0] = 'Any Size';
                    } else {
                        $lot_size_input_labels[0] = number_format($range_lot_size_exp[0]) . ' SF';
                    }

                    if (!isset($range_lot_size_exp[1])) {
                        $lot_size_input_labels[1] = 'Any Size';
                    } else {
                        $lot_size_input_labels[1] = number_format($range_lot_size_exp[1]) . ' SF';
                    }
                    break;
                case 'range_year':
                    $range_year     = str_replace('range_year-', '', $param);
                    $range_year_exp = explode('~', $range_year);

                    $min_year = $range_year_exp[0];
                    $max_year = $range_year_exp[1];

                    $min_year = ($range_year_exp[0] == 1900) ? '--' : $range_year_exp[0];
                    $max_year = ($range_year_exp[1] == 2020) ? '--' : $range_year_exp[1];
                    break;
                case 'water_desc':
                    $water_desc = str_replace('water_desc-', '', $param);
                    $water_desc = trim(strip_tags($water_desc));
                    break;
                case 'parking':
                    $parking = (int) $value;
                    break;
                case 'features':
                    $list_features = str_replace('features-', '', $param);
                    $features_exp  = explode('~', $list_features);

                    foreach ($features_exp as $feature) {
                        switch ($feature) {
                            case 'Swimming-Pool':
                                $features[] = 'pool';
                                break;
                            case 'Tennis':
                                $features[] = 'tennis';
                                break;
                            case 'Golf':
                                $features[] = 'golf';
                                break;
                            case 'Gated-Community':
                                $features[] = 'gated_community';
                                break;
														case 'Loft':
                              $features[] = 'loft';
                                break;
														case 'WaterFront':
                              $features[] = 'water_front';
																break;
														case 'Penthouse':
															$features[] = 'penthouse';
																break;
                        }
                    }
                    break;
                case 'order':
                    $order_value = str_replace('order-', '', $param);
                    $order       = strip_tags($order_value);
                    break;

                case 'page':
                    $page_value = str_replace('page-', '', $param);

                    $page       = (intval($page_value) < 1) ? 1 : intval($page_value);
                    break;
                case 'view':
                    $view_value   = str_replace('view-', '', $param);

                    if (!empty($default_view)){
                        if($default_view !='nmap'){
                        $default_view=$view_value;
                        }else if($default_view =='nmap'){
                            $default_view='map';
                        }
                    }
                    break;
            }
        }

        wp_enqueue_style('flex-idx-filter-pages-css');
        wp_enqueue_script('flex-idx-search-results-js');

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search_results.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_search_results.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_search_results.php';
				}

        return ob_get_clean();
    }

    add_shortcode('flex_idx_search', 'flex_idx_search_sc');
}

if (!function_exists('flex_idx_autocomplete_sc')) {
    function flex_idx_autocomplete_sc($atts)
    {
        global $flex_idx_info;

        $access_token          = flex_idx_get_access_token();

        $atts = shortcode_atts(array('method' => 'default'), $atts);

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $search_params = $flex_idx_info['search'];

        wp_enqueue_script('flex-idx-autocomplete');
        
        /*
        if (isset($search_params['property_types'])) {
            if (count($search_params['property_types']) == 2) {
                $flex_ac_pt_slug = 'residential';
            } else if (count($search_params['property_types']) == 3) {
						  	$flex_ac_pt_slug = 'residential';
						} else {
                $flex_ac_pt_slug = ($search_params['property_types'][0]['value'] == 1) ? 'condos' : 'SingleFamilyHomes';
            }
        }
        */

        ob_start();

        if ($atts['method']=='default') {
            if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_autocomplete.php')) {
                include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_autocomplete.php';
            } else {
                include FLEX_IDX_PATH . '/views/shortcode/flex_idx_autocomplete.php';
            }
        } else {
            if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_autocomplete_only.php')) {
                include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_autocomplete_only.php';
            } else {
                include FLEX_IDX_PATH . '/views/shortcode/flex_idx_autocomplete_only.php';
            }
        }

        return ob_get_clean();
    }

    add_shortcode('flex_autocomplete', 'flex_idx_autocomplete_sc');
}

if (!function_exists('flex_idx_off_market_listings_collection_sc')) {
    function flex_idx_off_market_listings_collection_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;
        $atts = shortcode_atts(array(
            'order'   => 'list_date-desc',
            'tag'     => 'default',
            'limit'     => 'default',
            'row'     => 'default',
            'title'   => ''
        ), $atts);


        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        wp_enqueue_script('idx_off_market_listing');
        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/off_market_listing_collection.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/off_market_listing_collection.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/off_market_listing_collection.php';
        }
        return ob_get_clean();
    }

    add_shortcode('idx_off_market_listing_collection', 'flex_idx_off_market_listings_collection_sc');
}

if (!function_exists('idx_off_market_listing_carousel_sc')) {
    function idx_off_market_listing_carousel_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;
        $atts = shortcode_atts(array(
            'order'   => 'list_date-desc',
            'tag'     => 'default',
            'limit'     => '20',
            "slider_item" => "4",
            'title'   => ''
        ), $atts);

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        wp_enqueue_script('idx_off_market_listing_carrosel');
        ob_start();

        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/off_market_listing_carrosell.php')) {
            include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/off_market_listing_carrosell.php';
        } else {
            include FLEX_IDX_PATH . '/views/shortcode/off_market_listing_carrosell.php';
        }
        return ob_get_clean();
    }

    add_shortcode('idx_off_market_listing_carousel', 'idx_off_market_listing_carousel_sc');
}

if (!function_exists('fb_flex_idx_property_detail_sc')) {
    function fb_flex_idx_property_detail_sc()
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        list($page, $slug) = $wp_request_exp;

        if (strstr($slug, '-rx-')) {
            $exp_slug = explode('-', $slug);
            $mls_num  = 'rx-' . end($exp_slug);
        } else {
            $exp_slug = explode('-', $slug);
            $mls_num  = end($exp_slug);
        }

        $type_lookup = 'active';

        if (preg_match('/^[sold\-(.*)]+/', $slug)) {
            $type_lookup = 'sold';
        } else if (preg_match('/^[rented\-(.*)]+/', $slug)) {
            $type_lookup = 'rent';
        } else if (preg_match('/^[pending\-(.*)]+/', $slug)) {
            $type_lookup = 'pending';
        } else {
            $type_lookup = 'active';
        }
        
        $AddressPrint='';
        if (!empty($mls_num) && $mls_num!=null) {
            $getTheAddress = str_replace('-'.$mls_num, "", $slug );
            $AddressPrint = str_replace("-", " ", $getTheAddress);
            
            $GLOBALS['property_mls'] = $mls_num;
            $GLOBALS['property_address'] = $AddressPrint;
        }

        $ip_address = get_client_ip_server();
        $referer    = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin     = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'mls_num'          => $mls_num,
            'type_lookup'      => $type_lookup,
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data'             => array(
                'ip_address'  => $ip_address,
                'url_referer' => $referer,
                'url_origin'  => $origin,
                'user_agent'  => $user_agent,
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
        $property    = (isset($response['success']) && $response['success'] === true) ? $response['payload'] : array();
        return $property;
    }
}

if (!function_exists('fb_flex_idx_buildind_social_sc')) {
    function fb_flex_idx_buildind_social_sc()
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead, $flex_idx_search_params;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        $building_idcpanel='';
        $custom_fields = get_post_custom(get_the_ID());
        $my_custom_field = isset($custom_fields['_flex_building_page_id']) ? $custom_fields['_flex_building_page_id'] : "";

        if (!empty($my_custom_field)) {
          foreach ( $my_custom_field as $key => $value ) {
            $building_idcpanel=$value;
          }
        }

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $building_idcpanel,
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDING_LOOKUP_v2);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        $GLOBALS['result_detailt_building']=$response;
        $search_params = $flex_idx_search_params;

        return $response;
    }
}



if (!function_exists('fb_flex_idx_sub_area_social_sc')) {
    function fb_flex_idx_sub_area_social_sc()
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead, $flex_idx_search_params;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        $building_idcpanel='';
        $custom_fields = get_post_custom(get_the_ID());
        $my_custom_field = isset($custom_fields['_flex_building_page_id']) ? $custom_fields['_flex_building_page_id'] : "";

        if (!empty($my_custom_field)) {
          foreach ( $my_custom_field as $key => $value ) {
            $building_idcpanel=$value;
          }
        }

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $building_idcpanel,
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SUB_AREA_LOOKUP);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        $GLOBALS['result_detailt_building']=$response;
        $search_params = $flex_idx_search_params;

        return $response;
    }
}

function insert_fb_in_head() {
    global $wpdb;
    $host= $_SERVER["HTTP_HOST"]; $url= $_SERVER["REQUEST_URI"];

    if( (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ){
        $domain_host= "https://". $host . $url;
    } else {
        $domain_host= "http://". $host . $url;
    }
      $result_content_slug = $wpdb->get_results("
      SELECT t1.post_name,t2.meta_value as idx_filter
      FROM {$wpdb->posts} t1
      inner join {$wpdb->postmeta} t2
      on t1.ID = t2.post_id
      where t1.post_type = 'flex-idx-pages' and t1.post_status = 'publish'
      and 
        ( t1.post_status = 'publish' and t2.meta_key = '_flex_id_page' and t2.meta_value = 'flex_idx_property_detail' ) or
        ( t1.post_status = 'publish' and t2.meta_key = '_flex_id_page' and t2.meta_value = 'flex_idx_building' ) or
        (t1.post_status = 'publish' and t2.meta_key = '_flex_id_page' and t2.meta_value = 'flex_idx_sub_area' )
      limit 3
      ",ARRAY_A);

      $property_slug='property';
      $building_slug='building';
      $sub_area_slug='sub-area';

      $keys_building=array_search('flex_idx_building', array_column($result_content_slug, 'idx_filter'));

      if (is_numeric($keys_building) )
          $building_slug=$result_content_slug[$keys_building]['post_name'];
      

      $keys_sub_area=array_search('flex_idx_sub_area', array_column($result_content_slug, 'idx_filter'));     
      if (is_numeric($keys_sub_area) )
          $sub_area_slug=$result_content_slug[$keys_sub_area]['post_name'];
      

      $keys_property=array_search('flex_idx_property_detail', array_column($result_content_slug, 'idx_filter'));     
      if (is_numeric($keys_property) )
          $property_slug=$result_content_slug[$keys_property]['post_name'];
    /*
        if (empty($building_slug) || $building_slug=='')
            $building_slug='building';
    */


    $postproperty = strpos($url,'/'.$property_slug.'/');
    $postbuilding = strpos($url,'/'.$building_slug.'/');
    $postsubarea  = strpos($url,'/'.$sub_area_slug.'/');

    if (is_numeric($postproperty) && $postproperty>=0 ) {
        $data = fb_flex_idx_property_detail_sc();  $GLOBALS['property']= $data;
        $address_property=$data['address_short'].' '.$data['address_large'];
        $mls_num_property=$data['mls_num'];
        $city_name=$data['city_name'];
        $is_rental=$data['is_rental'];

        if ($is_rental=='0') {
            $text_rental='For Sale';
        } else {
            $text_rental='For Rent';
        }

        if (empty($data) || !is_array($data) || (is_array($data) && count($data)==0) ) {
            if (!empty($GLOBALS) && is_array($GLOBALS) && array_key_exists('property_address', $GLOBALS) && !empty($GLOBALS['property_address'])) {
                $address_property= $GLOBALS['property_address'];
            }
        }

        if (empty($mls_num_property)) {
            if (!empty($GLOBALS) && is_array($GLOBALS) && array_key_exists('property_mls', $GLOBALS) && !empty($GLOBALS['property_mls'])) {
                $mls_num_property= $GLOBALS['property_mls'];
            }
        }      

    if (isset($data["remark"]) && !empty($data["remark"])) {
        $addressPropertyDescription = $data["remark"];
    } else {
        $addressPropertyDescription='Photos and Property information for '.$address_property.' | '.$mls_num_property.'. Obtain complete property details, maps, schools and more. Contact or request additional information';
    }

    $keywordsProperty=$address_property.' , '.$city_name.' Real Estate, '.$city_name.' properties '.$text_rental;
    $property_image='';
    if (array_key_exists('gallery', $data)) {
        if (array_key_exists(0, $data['gallery'])) {
            $property_image_boo =preg_match('/(https)|(http)/',$data['gallery'][0]);
            $property_image=$data['gallery'][0];
            if (is_numeric($property_image_boo)) {
                if ($property_image_boo=='0')
                    $property_image='http:'.$data['gallery'][0];
            }
        }             
    }
    remove_action( 'wp_head', 'rel_canonical' );
    add_action( 'wp_head', 'idx_property_rel_canonical' );

    ?>
      <title><?php echo get_bloginfo('name');?> - <?php echo $address_property.' | '.get_bloginfo() ;?></title>
      <meta property="og:title" content="<?php bloginfo('name');?> - <?php echo $address_property.' | '.get_bloginfo() ;?>"/>
      <meta property="og:type" content="website"/>
      <meta property="og:url" content="<?php echo $domain_host; ?>"/>
      <meta property="og:description" content="<?php echo $addressPropertyDescription; ?>"/>
      <meta property="og:image" content="<?php echo $property_image; ?>"/>
      <meta name="keywords" content="<?php echo $keywordsProperty; ?>" />
      <meta name="description" content="<?php echo $addressPropertyDescription; ?>">
    <?php  } ?>

    <?php if (is_numeric($postbuilding) && $postbuilding>=0 ) {
        $url_image='';
        $og_name_building='';
        $building_addresses='';
        $og_building=fb_flex_idx_buildind_social_sc();

        if (!empty($og_building) && is_array($og_building) && array_key_exists('success', $og_building) && $og_building['success']!=false ) {
            
            $og_building_serial_address = @unserialize($og_building['payload']['address_building']);

            if (is_array($og_building_serial_address) && count($og_building_serial_address)>0 ) {
                $og_building_addresses=$og_building_serial_address[0];
            }
            if ( is_array($og_building['payload']['gallery_building']) ) {
                if (count($og_building['payload']['gallery_building'])>0) {
                    $url_image=$og_building['payload']['gallery_building'][0]['url_image'];
                }                
            }

            $og_name_building=$og_building['payload']['name_building'];
        } ?>
      <meta property="og:title" content="<?php echo $og_name_building; ?>"/>
      <meta property="og:type" content="website"/>
      <meta property="og:url" content="<?php echo $domain_host; ?>"/>
      <meta property="og:description" content="<?php echo strip_tags($og_building_addresses); ?>"/>
      <meta property="og:image" content="<?php echo $url_image; ?>"/>
    <?php  } ?>


    <?php if (is_numeric($postsubarea) && $postsubarea>=0 ) {
        $url_image='';
        $og_name_building='';
        $building_addresses='';
        $og_building=fb_flex_idx_sub_area_social_sc();

        if (!empty($og_building) && is_array($og_building) && array_key_exists('success', $og_building) && $og_building['success']!=false ) {
            
            $og_building_serial_address = @unserialize($og_building['payload']['address_building']);

            if (is_array($og_building_serial_address) && count($og_building_serial_address)>0 ) {
                $og_building_addresses=$og_building_serial_address[0];
            }
            if ( is_array($og_building['payload']['gallery_building']) ) {
                if (count($og_building['payload']['gallery_building'])>0) {
                    $url_image=$og_building['payload']['gallery_building'][0]['url_image'];
                }                
            }

            $og_name_building=$og_building['payload']['name_building'];
        } ?>
      <meta property="og:title" content="<?php echo $og_name_building; ?>"/>
      <meta property="og:type" content="website"/>
      <meta property="og:url" content="<?php echo $domain_host; ?>"/>
      <meta property="og:description" content="<?php echo strip_tags($og_building_addresses); ?>"/>
      <meta property="og:image" content="<?php echo $url_image; ?>"/>
    <?php  } ?>    

<?php
}
add_action( 'wp_head', 'insert_fb_in_head', 0 );

if (!function_exists('idx_property_rel_canonical')) {
function idx_property_rel_canonical() {
    $host= $_SERVER["HTTP_HOST"]; $url= $_SERVER["REQUEST_URI"];
    $domain_host='';
    if( (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ){
        $domain_host= "https://". $host . $url;
    } else {
        $domain_host= "http://". $host . $url;
    }
      echo "<link rel='canonical' href='".$domain_host."' />\n";
  }
}



if (!function_exists('flex_idx_property_detail_sc')) {
    function flex_idx_property_detail_sc($atts, $content = null)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token = flex_idx_get_access_token();
        $search_params = $flex_idx_info['search'];

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        list($page, $slug) = $wp_request_exp;

        if (strstr($slug, '-rx-')) {
            $exp_slug = explode('-', $slug);
            $mls_num  = 'rx-' . end($exp_slug);
        } else {
            $exp_slug = explode('-', $slug);
            $mls_num  = end($exp_slug);
        }

        $type_lookup = 'active';
				$prefix_property_slug = "/";

        if (preg_match('/^sold\-(.*)/', $slug)) {
            $type_lookup = 'sold';
						$prefix_property_slug = "/sold-";
        } else if (preg_match('/^rented\-(.*)/', $slug)) {
            $type_lookup = 'rent';
						$prefix_property_slug = "/rented-";
        } else if (preg_match('/^pending\-(.*)/', $slug)) {
            $type_lookup = 'pending';
						$prefix_property_slug = "/pending-";
        } else {
            $type_lookup = 'active';
						$prefix_property_slug = "/";
        }

        $ip_address = get_client_ip_server();
        $referer    = isset($_SERVER['HTTP_REFERER']) ? trim(strip_tags($_SERVER['HTTP_REFERER'])) : '';
        $origin     = isset($_SERVER['HTTP_HOST']) ? trim(strip_tags($_SERVER['HTTP_HOST'])) : '';
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim(strip_tags($_SERVER['HTTP_USER_AGENT'])) : '';

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'mls_num'          => $mls_num,
            'type_lookup'      => $type_lookup,
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials,
            'data'             => array(
                'ip_address'  => $ip_address,
                'url_referer' => $referer,
                'url_origin'  => $origin,
                'user_agent'  => $user_agent,
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
        $property    = (isset($response['success']) && $response['success'] === true) ? $response['payload'] : array();

        wp_enqueue_script('flex-idx-property-js');

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';


        $property_permalink = rtrim($flex_idx_info['pages']['flex_idx_property_detail']['guid'], "/") . $prefix_property_slug . $property['slug'];

        // build facebook url share
        $site_title = get_bloginfo('name');

        $facebook_share_url    = '//www.facebook.com/sharer/sharer.php';
        $facebook_share_params = http_build_query(array(
            'u'           => $property_permalink,
            'picture'     => $property['gallery'][0],
            'title'       => $property['address_short'] . ' ' . $property['address_large'],
            'caption'     => $site_title,
            'description' => $property['remark'],
        ));

        $facebook_share_url .= '?' . $facebook_share_params;

        // build twitter url share
        $twitter_text = $property['address_short'] . ' ' . $property['address_large'];

        $twitter_share_url_params = http_build_query(array(
            'text' => $twitter_text,
            'url'  => $property_permalink,
        ));

        $twitter_share_url = 'https://twitter.com/intent/tweet?' . $twitter_share_url_params;

				$agent_info = get_option('idxboost_agent_info');
				$registration_is_forced = (isset($agent_info["force_registration"]) && (true === $agent_info["force_registration"])) ? true : false;

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_property_detail.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_property_detail.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_property_detail.php';
				}

        $output = ob_get_clean();

        return $output;
    }

    add_shortcode('flex_idx_property_detail', 'flex_idx_property_detail_sc');
}

if (!function_exists('flex_idx_quick_search_sc')) {
    function flex_idx_quick_search_sc($atts, $content = null)
    {
        global $flex_idx_info;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        wp_enqueue_style('idxboost-quick-search-css');
        wp_enqueue_script('idxboost-quick-search-js');

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_quick_search.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_quick_search.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_quick_search.php';
				}

        return ob_get_clean();
    }

    add_shortcode('flex_idx_quick_search', 'flex_idx_quick_search_sc');
}

if (!function_exists('flex_idx_contact_form_sc')) {
    function flex_idx_contact_form_sc($atts, $content = null)
    {
        $atts = shortcode_atts(array(
            'id_form'   => 'flex_idx_contact_form',
            "map" => "show"
        ), $atts);

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        if ($atts["map"] == "show") {
            wp_enqueue_script('google-maps-api');
        }    
        wp_enqueue_script('idxboost-contact', FLEX_IDX_URI. 'js/dgt-contact.js',  array(), iboost_get_mod_time("js/dgt-contact.js") );

        wp_localize_script('idxboost-contact', 'flex_idx_contact', array(
            'ajaxUrl'        => admin_url('admin-ajax.php'),
            'ajaxUrlContact' => FLEX_IDX_URI. '/inc/request-contact.php',
            'siteUrl'        => site_url(),
            'idxboost_uri'        => FLEX_IDX_URI
        ));

        ob_start();

                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_contact_form.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_contact_form.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/flex_idx_contact_form.php';
                }

        return ob_get_clean();
    }

    add_shortcode('flex_idx_contact_form', 'flex_idx_contact_form_sc');
}

if (!function_exists('idx_sold_properties_filter_sc')) {
    function idx_sold_properties_filter_sc($atts, $content = null)
    {
        global $flex_idx_info;
        $atts = shortcode_atts(array(
            'city_id'   => '3',
            'price_min'   => '0',
            'price_max'   => '1000000',
            'sort'   => 'price-desc',
            'class_id'   => '2',
            'view'   => 'grid',
            'property_style'   => '',
            'close_date_start'   => '20200101',
            'close_date_end'   => '20200331',
        ), $atts);

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        wp_enqueue_style('flex-idx-filter-pages-css');
        wp_register_script('idx-filter-sold', FLEX_IDX_URI . 'js/idx-filter-sold-statistics.js', array(
            'underscore',
            'underscore-mixins',
            'flex-idx-filter-js-scroll',
            'flex-idx-filter-jquery-ui',
            'flex-idx-filter-jquery-ui-touch',
            'flex-lazyload-plugin',
            'google-maps-api', 'google-maps-utility-library-richmarker', 'google-maps-utility-library-infobubble',
        ), iboost_get_mod_time("js/idx-filter-sold-statistics.js"));

        wp_enqueue_script('idx-filter-sold');
                

        $class_multi=time();

        if( !empty($_GET) ){
            $price='0';
            $price_array=[];
            if( array_key_exists('price',$_GET) ){
                $price= $_GET['price'];
                $price_array=explode('~',$price);
                if( is_array($price_array) && count($price_array) > 0 ){
                    $atts['price_min']=$price_array[0];
                    $atts['price_max']=$price_array[1];
                }
            }

            if( array_key_exists('city',$_GET) ){
                $atts['city_id']=$_GET['city'];
            }

            if( array_key_exists('property_type',$_GET) ){
                $atts['class_id']=$_GET['property_type'];
            }

            if( array_key_exists('property_style',$_GET) ){
                $atts['property_style']=$_GET['property_style'];
            }            

            if( array_key_exists('sort',$_GET) ){
                $atts['sort']=$_GET['sort'];
            }
            if( array_key_exists('close_date',$_GET) ){
                $close_date= $_GET['close_date'];
                $close_date_array=explode('~',$close_date);
                if( is_array($close_date_array) && count($close_date_array) > 0 ){
                    $atts['close_date_start']=$close_date_array[0];
                    $atts['close_date_end']=$close_date_array[1];
                }
            }
        }

    $price_select='1';

    if($atts['price_min'] == '0' && $atts['price_max'] == '1000000'){
        $price_select="1";
    }else if($atts['price_min'] == '1000001' && $atts['price_max'] == '2000000'){
        $price_select="2";
    }else if($atts['price_min'] == '2000001' && $atts['price_max'] == '3000000'){
        $price_select="3";
    }else if($atts['price_min'] == '3000001' && $atts['price_max'] == '5000000'){
        $price_select="4";
    }else if($atts['price_min'] == '5000001' && $atts['price_max'] == '7500000'){
        $price_select="5";
    }else if($atts['price_min'] == '7500001' && $atts['price_max'] == '100000000'){
        $price_select="6";
    }else if($atts['price_min'] == '0' && $atts['price_max'] == '100000000'){
        $price_select="7";
    }


        wp_localize_script('idx-filter-sold', 'flex_idx_sold_statistics', array(
            'ajaxUrl'        => admin_url('admin-ajax.php'),
            'propertyDetailPermalink' => rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"),            
            'wpsite'                => get_permalink(),
            'class_form'   => $class_multi,
            'city_id'   => $atts['city_id'],
            'price_min'   => $atts['price_min'],
            'price_max'   => $atts['price_max'],
            'sort'   => $atts['sort'],
            'class_id'   => $atts['class_id'],
            'page'   => 1,
            'property_style'   => $atts['property_style'],
            'close_date_start'   => $atts['close_date_start'],
            'close_date_end'   => $atts['close_date_end'],
        ));

        ob_start();

                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/sold_properties_filter.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/sold_properties_filter.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/sold_properties_filter.php';
                }

        return ob_get_clean();
    }

    add_shortcode('sold_properties_filter', 'idx_sold_properties_filter_sc');
}


if (!function_exists('flex_idx_agent_contact_form_sc')) {
    function flex_idx_agent_contact_form_sc($atts, $content = null)
    {
        $atts = shortcode_atts(array(
            'id_form'   => 'idx_agent_contact_form',
        ), $atts);

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        wp_enqueue_script('idxboost_agent_contact', FLEX_IDX_URI. 'js/idx-agent-contact.js',  array(), iboost_get_mod_time("js/idx-agent-contact.js") );

        wp_localize_script('idxboost_agent_contact', 'flex_idx_agent_contact', array(
            'ajaxUrl'        => admin_url('admin-ajax.php'),
            'siteUrl'        => site_url(),
            'idxboost_uri'        => FLEX_IDX_URI
        ));

        ob_start();

                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_agent_contact_form.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_agent_contact_form.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idx_agent_contact_form.php';
                }

        return ob_get_clean();
    }

    add_shortcode('flex_idx_agent_contact_form', 'flex_idx_agent_contact_form_sc');
}


if (!function_exists('idx_multi_slider_type_sc')) {
    function idx_multi_slider_type_sc($atts, $content = null)
    {
        global $wp, $wpdb, $flex_idx_info;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

                // generate form ids
                $unique_filter_form_ID = mt_rand();

        $atts = shortcode_atts(array(
            'id'   => '',
            'title_exclusive'   => '',
            'title_recent_sale'   => '',
            'link_exclusive'   => '',
            'link_recent_sale'   => '',
            'mode' => 'default',
            'type' => '0',
            'limit' => 'default',
            'method'=> '0'
        ), $atts);

        $list_type=[];

        if ($atts['type'] != 'default') {
            $temp_type=explode('|',$atts['type']);
            if (!empty($temp_type) && is_array($temp_type) && count($temp_type)>0) {
                $list_type=$temp_type;
            }
        }

        wp_enqueue_style('flex-idx-filter-pages-css');
        wp_localize_script('idxboost_slider_type', 'idx_ajax_param_slider',  ["type" => $list_type , "limit" => $atts["limit"] ] );
        wp_enqueue_script('idxboost_slider_type');


        if(isset($atts["mode"]) && ($atts["mode"] === "multi-slider")) {
            if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_filter_multi_slider_ajax.php')) {
                include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_filter_multi_slider_ajax.php';
            } else {
                include FLEX_IDX_PATH . '/views/shortcode/idx_filter_multi_slider_ajax.php';
            }
        }        

    }
    add_shortcode('idx_multi_slider_type', 'idx_multi_slider_type_sc');
}

if (!function_exists('flex_idx_filter_sc')) {
    function flex_idx_filter_sc($atts, $content = null)
    {
        global $wp, $wpdb, $flex_idx_info;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

				// generate form ids
				$unique_filter_form_ID = mt_rand();

        $atts = shortcode_atts(array(
            'id'   => '',
            'title'   => '',
            'link'   => '',
            'name_button'   => 'view more properties',
            'mode' => 'default',
            'multi_type' => 'default',
            'type' => '0',
            'limit' => 'default',
            'sale_type' => 'default',
            'method'=> '0',
            "target_id" => "",
            "sale_link" => "",
            "rent_link" => "",
            "target_label" => "",
            "heading" => "",
            'row'            => 'default',
            "oh" => "0",
            "slider_item" => "4",
            "slider_play" => "0",
            "slider_speed" => "5000",
            "reference" => "no",
            "max" => 0
        ), $atts);      

        $typeworked='0';
        $default_view = $flex_idx_info['search']['default_view'];

        if (isset($atts['type'])) {
            $typeworked=$atts['type'];
        }

        if ('' != $atts['id']) {
            $atts['type'] = 0;
        }

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $valid_sortings = array(
            'order-price-desc', 'order-price-asc',
            'order-bed-desc', 'order-bed-asc',
            'order-sqft-desc', 'order-sqft-asc',
            'order-year-desc', 'order-year-asc',
            'order-list_date-desc', 'order-list_date-asc',
        );

        $valid_views = array('view-grid', 'view-list', 'view-map');

        $order = (isset($wp_request_exp[1]) && in_array($wp_request_exp[1], $valid_sortings)) ? $wp_request_exp[1] : null;
        $view  = (isset($wp_request_exp[2]) && in_array($wp_request_exp[2], $valid_views)) ? $wp_request_exp[2] : '';
        $page  = isset($wp_request_exp[3]) ? (int) preg_replace('/[^\d]/', '', $wp_request_exp[3]) : 1;

        $param_url=[];

        $sale_type=[];

        if ($atts['oh']=="1") {
            $param_url['oh']="1";
        }else{
            $param_url['oh']="0";
        }

        if ($atts['sale_type']=='for-sale') {
            $sale_type[]=0;
        }else if($atts['sale_type']=='for-rent') {
            $sale_type[]=1;
        }  

        if ($atts['mode']=='multi-slider') {
            $sale_type[]=0;
        }

        if (!empty($_GET)) {

            if(array_key_exists('price', $_GET)){
            $param_url['min_price']='--';
            $param_url['max_price']='--';
                if (!empty($_GET['price'])) {
                    $temparray_price=explode('~',$_GET['price']);
                    if (is_array($temparray_price)) {
                        if (array_key_exists(0,$temparray_price))
                            $param_url['min_price']=$temparray_price[0];

                        if (array_key_exists(0,$temparray_price))
                            $param_url['max_price']=$temparray_price[1];
                    }
                }
            }

            if(array_key_exists('price_rent', $_GET)){
            $param_url['min_rent_price']='--';
            $param_url['max_rent_price']='--';
                if (!empty($_GET['price'])) {
                    $temparray_price_rent=explode('~',$_GET['price']);
                    if (is_array($temparray_price_rent)) {
                        if (array_key_exists(0,$temparray_price_rent))
                            $param_url['min_rent_price']=$temparray_price_rent[0];

                        if (array_key_exists(0,$temparray_price_rent))
                            $param_url['max_rent_price']=$temparray_price_rent[1];
                    }
                }
            }

            if(array_key_exists('bed', $_GET)){
            $param_url['min_beds']='--';
            $param_url['max_beds']='--';
                if (!empty($_GET['bed'])) {
                    $temparray_bed=explode('~',$_GET['bed']);
                    if (is_array($temparray_bed)) {
                        if (array_key_exists(0,$temparray_bed))
                            $param_url['min_beds']=$temparray_bed[0];

                        if (array_key_exists(0,$temparray_bed))
                            $param_url['max_beds']=$temparray_bed[1];
                    }
                }
            }


            if(array_key_exists('bath', $_GET)){
            $param_url['min_baths']='--';
            $param_url['max_baths']='--';
                if (!empty($_GET['bath'])) {
                    $temparray_bath=explode('~',$_GET['bath']);
                    if (is_array($temparray_bath)) {
                        if (array_key_exists(0,$temparray_bath))
                            $param_url['min_baths']=$temparray_bath[0];

                        if (array_key_exists(0,$temparray_bath))
                            $param_url['max_baths']=$temparray_bath[1];
                    }
                }
            }

            if(array_key_exists('sqft', $_GET)){
            $param_url['min_sqft']='--';
            $param_url['max_sqft']='--';
                if (!empty($_GET['sqft'])) {
                    $temparray_sqft=explode('~',$_GET['sqft']);
                    if (is_array($temparray_sqft)) {
                        if (array_key_exists(0,$temparray_sqft))
                            $param_url['min_sqft']=$temparray_sqft[0];

                        if (array_key_exists(0,$temparray_sqft))
                            $param_url['max_sqft']=$temparray_sqft[1];
                    }
                }
            }

            if(array_key_exists('lotsize', $_GET)){
            $param_url['min_lotsize']='--';
            $param_url['max_lotsize']='--';
                if (!empty($_GET['lotsize'])) {
                    $temparray_bath=explode('~',$_GET['lotsize']);
                    if (is_array($temparray_bath)) {
                        if (array_key_exists(0,$temparray_bath))
                            $param_url['min_lotsize']=$temparray_bath[0];

                        if (array_key_exists(0,$temparray_bath))
                            $param_url['max_lotsize']=$temparray_bath[1];
                    }
                }
            }

            if(array_key_exists('yearbuilt', $_GET)){
            $param_url['min_year']='--';
            $param_url['max_year']='--';
                if (!empty($_GET['yearbuilt'])) {
                    $temparray_year=explode('~',$_GET['yearbuilt']);
                    if (is_array($temparray_year)) {
                        if (array_key_exists(0,$temparray_year))
                            $param_url['min_year']=$temparray_year[0];

                        if (array_key_exists(0,$temparray_year))
                            $param_url['max_year']=$temparray_year[1];
                    }
                }
            }

            if(array_key_exists('fea', $_GET))
                $param_url['features']=$_GET['fea'];

            if(array_key_exists('type', $_GET))
                $param_url['tab']=$_GET['type'];

            if(array_key_exists('waterdesc', $_GET))
                $param_url['waterfront']=$_GET['waterdesc'];

            if(array_key_exists('parking', $_GET))
                $param_url['parking']=$_GET['parking'];
            
            if(array_key_exists('pagenum', $_GET))
                $param_url['pagenum']=$_GET['pagenum'];

            if(array_key_exists('sort', $_GET))
                $param_url['sort']=$_GET['sort'];                                            

        }

        $list_type=[];

        $sendParams = array(
            'filter_id'        => $atts['id'],
            'listing_type'     => $atts['type'],
            'list_type'     => $list_type,
            'limit'     => $atts['limit'],
            'order'            => $order,
            'sale_type' => $sale_type,
            'view'             => $view,
            'page'             => $page,
            'idx'            => $param_url,
            'access_token'     => $access_token,
            'version_endpoint'     => 'new',
            'flex_credentials' => $flex_lead_credentials
        );

        // var_dump($sendParams);
        // exit;


        wp_enqueue_style('flex-idx-filter-pages-css');


        if(isset($atts["mode"]) && ($atts["mode"] != "slider")) {

                $is_recent_sales='no';
                $endpointFilter=FLEX_IDX_API_MARKET;
                if ($atts['type']=='2') {
                    wp_localize_script('idxboost_exclusive_listing', 'is_recent_sales', $is_recent_sales );
                    wp_enqueue_script('idxboost_exclusive_listing');
                    $endpointFilter=FLEX_IDX_API_MARKET_EXCLUSIVE_LISTINGS;
                    if ($atts["reference"] =="yes") {
                        wp_localize_script('idxboost_exclusive_listing', 'is_references_active', $atts["reference"] );
                    }

                }elseif($atts['type']=='1') {
                    $is_recent_sales='yes';
                    wp_localize_script('idxboost_exclusive_listing', 'is_recent_sales',$is_recent_sales);
                    wp_enqueue_script('idxboost_exclusive_listing');
                    $endpointFilter=FLEX_IDX_API_MARKET_RECENT_SALE;
                    if ($atts["reference"] =="yes") {
                        wp_localize_script('idxboost_exclusive_listing', 'is_references_active', $atts["reference"] );
                    }

                }else{
                    if ($atts["reference"] =="yes") {
                        wp_localize_script('flex-idx-filter-js', 'is_references_active', $atts["reference"] );
                    }
                    wp_enqueue_script('flex-idx-filter-js');
                }
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $endpointFilter );
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

                $server_output = curl_exec($ch);
                $response = json_decode($server_output, true);

                if ($atts['type']=='2' || $atts['type']=='1') {
                    wp_localize_script('idxboost_exclusive_listing', 'filter_metadata', json_encode($response) );
                }else{
                    wp_localize_script('flex-idx-filter-js', 'filter_metadata', json_encode($response) );
                }

                if (isset($response['info']['property_type'])) {
                  $list_ptypes = array('tw', '1', '2','valand','mf');
                  $exp_property_type = explode('|', $response['info']['property_type']);

                  $catch_list_ptype = array();

                  foreach($exp_property_type as $ptype) {

                    if (in_array($ptype,$list_ptypes) ) {
                      $catch_list_ptype[] = ["value" => $ptype, "label" => $list_ptypes[$ptype]];
                    }
                  }
                  $response['info']['property_type_list'] = $catch_list_ptype;
                }

                $sendParams_count = array(
                    'access_token'     => $access_token,
                    'flex_credentials' => $flex_lead_credentials
                );

                $chcanti = curl_init();

                curl_setopt($chcanti, CURLOPT_URL, FLEX_IDX_API_FAVORITES_LIST);
                curl_setopt($chcanti, CURLOPT_POST, 1);
                curl_setopt($chcanti, CURLOPT_POSTFIELDS, http_build_query($sendParams_count));
                curl_setopt($chcanti, CURLOPT_RETURNTRANSFER, true);
                @curl_setopt($chcanti, CURLOPT_REFERER, ib_get_http_referer());

                $server_output_canti = curl_exec($chcanti);
                curl_close($chcanti);

                $response_canti = json_decode($server_output_canti, true);

        }

        $search_params = $flex_idx_info['search'];

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';

				$ptypes_checked = array();

	      if (!empty($response)) {
	          if (array_key_exists('info', $response)) {
	              foreach($response['info']['property_type_list'] as $ptype_filter) {
	                  $ptypes_checked[] = $ptype_filter["value"];
	              }
	          }
	      }

				$agent_info = get_option('idxboost_agent_info');
				$registration_is_forced = (isset($agent_info["force_registration"]) && (true === $agent_info["force_registration"])) ? true : false;
				$board_id=$flex_idx_info['board_id'];

        $default_view='';
		   if (!empty($default_view)){
                        if($default_view !='nmap'){
                        $default_view=$view_value;
                        }else if($default_view =='nmap'){
                            $default_view='map';
                        }
                    }
        ob_start();

        if (isset($atts['mode']) && ($atts['mode'] === 'thumbs')) {
            $featured_filter_page = $wpdb->get_row("
            SELECT ID, post_title
            FROM {$wpdb->posts} t1
            INNER JOIN {$wpdb->postmeta} t2
            ON t1.ID = t2.post_id
            WHERE t1.post_type = 'flex-filter-pages'
            AND t1.post_status = 'publish'
            AND t2.meta_key = '_flex_filter_page_show_home'
            AND t2.meta_value = 1
            ", ARRAY_A);

						if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_thumbs.php')) {
							include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_thumbs.php';
						} else {
							include FLEX_IDX_PATH . '/views/shortcode/flex_idx_filter_thumbs.php';
						}
        } else if(isset($atts["mode"]) && ($atts["mode"] === "multi-slider")) {
                    $response_rentals=idx_exclusive_operation_slider_xhr_fn($atts['type'],'','1');
                    wp_enqueue_script('idx-exclusive-thumbs', FLEX_IDX_URI . 'js/idx-exclusive-thumbs.js');
                    if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_filter_multi_slider.php')) {
                        include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_filter_multi_slider.php';
                    } else {
                        include FLEX_IDX_PATH . '/views/shortcode/idx_filter_multi_slider.php';
                    }
                } else if(isset($atts["mode"]) && ($atts["mode"] === "slider")) {
                   
                    wp_enqueue_script('ib_slider_filter');

                    if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_only_filter_thumb.php')) {
                        include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_only_filter_thumb.php';
                    } else {
                        include FLEX_IDX_PATH . '/views/shortcode/idx_only_filter_thumb.php';
                    }
                }else if(isset($atts["mode"]) && ($atts["mode"] === "grid")) {
					if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_grid.php')) {
						include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_grid.php';
					} else {
						include FLEX_IDX_PATH . '/views/shortcode/flex_idx_filter_grid.php';
					}
				} else if (isset($atts["mode"]) && ($atts["mode"] === "minimal")) {
					if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_minimal.php')) {
						include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_minimal.php';
					} else {
						include FLEX_IDX_PATH . '/views/shortcode/flex_idx_filter_minimal.php';
					}
				} else if(isset($atts["mode"]) && ($atts["mode"] === "carrousel")) {
					if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_carrousel.php')) {
						include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_carrousel.php';
					} else {
						include FLEX_IDX_PATH . '/views/shortcode/flex_idx_filter_carrousel.php';
					}
				} else if(isset($atts["type"]) && ($atts["type"] === "2" || $atts["type"] === "1")) {
                    if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_exclusive_listing.php')) {
                        include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_exclusive_listing.php';
                    } else {
                        include FLEX_IDX_PATH . '/views/shortcode/idxboost_exclusive_listing.php';
                    }
                } else {
					if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter.php')) {
						include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter.php';
					} else {
						include FLEX_IDX_PATH . '/views/shortcode/flex_idx_filter.php';
					}
        }

        return ob_get_clean();
    }

    add_shortcode('flex_idx_filter', 'flex_idx_filter_sc');
}

if (!function_exists('idxboost_filter_collection_sc')) {
    function idxboost_filter_collection_sc($atts, $content = null)
    {
        global $wp, $wpdb, $flex_idx_info;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }
        // generate form ids
        $unique_filter_form_ID = mt_rand();

        $atts = shortcode_atts(array(
            'id'   => '',
            'mode' => 'default',
            'type' => '0',
            'limit' => 'default',
            'method'=> '0',
            "target_id" => "",
            "target_label" => "",
            "max" => 0
        ), $atts);

        $typeworked='0';

        if (isset($atts['type'])) {
            $typeworked=$atts['type'];
        }

        if ('' != $atts['id']) {
            $atts['type'] = 0;
        }

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $valid_sortings = array(
            'order-price-desc', 'order-price-asc',
            'order-bed-desc', 'order-bed-asc',
            'order-sqft-desc', 'order-sqft-asc',
            'order-year-desc', 'order-year-asc',
            'order-list_date-desc', 'order-list_date-asc',
        );

        $valid_views = array('view-grid', 'view-list', 'view-map');

        $order = (isset($wp_request_exp[1]) && in_array($wp_request_exp[1], $valid_sortings)) ? $wp_request_exp[1] : null;
        $view  = (isset($wp_request_exp[2]) && in_array($wp_request_exp[2], $valid_views)) ? $wp_request_exp[2] : '';
        $page  = isset($wp_request_exp[3]) ? (int) preg_replace('/[^\d]/', '', $wp_request_exp[3]) : 1;

        $sendParams = array(
            'filter_id'        => $atts['id'],
            'listing_type'     => $atts['type'],
            'order'            => $order,
            'view'             => $view,
            'page'             => $page,
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        wp_enqueue_style('flex-idx-filter-pages-css');
        wp_enqueue_script('flex-idx-filter-js');

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_collection_pc.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_collection_pc.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/idxboost_collection_pc.php';
				}

        return ob_get_clean();
    }

    add_shortcode('idxboost_filter_collection', 'idxboost_filter_collection_sc');
}

if (!function_exists('idx_agent_filter_sc')) {
    function idx_agent_filter_sc($atts, $content = null)
    {
        global $wp, $wpdb, $flex_idx_info;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'id'   => '',
            'mode' => 'default',
            'type' => '0',
            'searchbar' =>'no',
            'limit' => 'default'
        ), $atts);

        if ($atts['type']=='agent' ) {
            $typefilt='4';
        }elseif ($atts['type']=='office') {
            $typefilt='5';
        }else{
            $typefilt='4';
        }

        if ('' != $atts['id']) {
            $atts['type'] = 0;
        }

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $valid_sortings = array(
            'order-price-desc', 'order-price-asc',
            'order-bed-desc', 'order-bed-asc',
            'order-sqft-desc', 'order-sqft-asc',
            'order-year-desc', 'order-year-asc',
            'order-list_date-desc', 'order-list_date-asc',
        );

        $valid_views = array('view-grid', 'view-list', 'view-map');

        $order = (isset($wp_request_exp[1]) && in_array($wp_request_exp[1], $valid_sortings)) ? $wp_request_exp[1] : null;
        $view  = (isset($wp_request_exp[2]) && in_array($wp_request_exp[2], $valid_views)) ? $wp_request_exp[2] : '';
        $page  = isset($wp_request_exp[3]) ? (int) preg_replace('/[^\d]/', '', $wp_request_exp[3]) : 1;

        $sendParams = array(
            'filter_id'        => $atts['id'],
            'listing_type'     => $typefilt,
            'order'            => $order,
            'view'             => $view,
            'page'             => $page,
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        wp_enqueue_style('flex-idx-filter-pages-css');
        // wp_enqueue_style('flex-idx-search-filter-css');
        wp_enqueue_script('flex-idx-filter-js');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_TRACK_PROPERTY_AGENT_OR_OFFICE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        wp_localize_script('flex-idx-filter-js', 'filter_metadata', json_encode($response) );
        

        $search_params = $flex_idx_info['search'];

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_agent_office.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_filter_agent_office.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_filter_agent_office.php';
				}

        return ob_get_clean();
    }

    add_shortcode('idx_agent_filter', 'idx_agent_filter_sc');
}



if (!function_exists('flex_idx_buildind_sc')) {
    function flex_idx_buildind_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'building_id' => '',
            'mode'        => 'default',
        ), $atts);

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $atts['building_id'],
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        wp_enqueue_style('flex-idx-filter-pages-css');
        wp_enqueue_script('flex-idx-building-js');

        if (array_key_exists('result_detailt_building',$GLOBALS) ) {
            $response=$GLOBALS['result_detailt_building'];
        }else{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDING_LOOKUP_v2);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

            $server_output = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($server_output, true);
            $GLOBALS['result_detailt_building']=$response;
        }

        $search_params = $flex_idx_info['search'];

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';
        $default_floor_plan=[];
        
        if (is_array($flex_idx_info) && count($flex_idx_info)>0) {
            
            if ( array_key_exists('default_floor_plan',$flex_idx_info['search']) && !empty($flex_idx_info['search']['default_floor_plan'])) {
                if (!is_array($flex_idx_info['search']['default_floor_plan'])) {
                    $default_floor_plan=@json_decode($flex_idx_info['search']['default_floor_plan'],true);
                }
            }
        }

        ob_start();

        if ( !empty($response) && is_array($response) && count($response)>0 && 
            ( array_key_exists('type_building',$response['payload']) && $response['payload']['type_building']=='1' ) &&
            ( array_key_exists('new_template',$response['payload']) && $response['payload']['new_template']=='1' )
             ) {

                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_building_template_pre_construction.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_building_template_pre_construction.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idx_building_template_pre_construction.php';
                }

        }else{

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_building.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_building.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_building.php';
				}

        }


        return ob_get_clean();
    }

    add_shortcode('flex_idx_building', 'flex_idx_buildind_sc');
}


if (!function_exists('flex_idx_sub_area_sc')) {
    function flex_idx_sub_area_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'building_id' => '',
            'mode'        => 'default',
        ), $atts);

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $atts['building_id'],
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        wp_enqueue_style('flex-idx-filter-pages-css');
        add_action('wp_footer', 'ib_sub_area_footer');

        if (array_key_exists('result_detailt_building',$GLOBALS) ) {
            $response=$GLOBALS['result_detailt_building'];
        }else{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SUB_AREA_LOOKUP);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

            $server_output = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($server_output, true);
            $GLOBALS['result_detailt_building']=$response;
        }

        if (empty($response) || $response== null || $response=='') {
            return '<div class="gwr" style="margin: 20px 0"><div class="message-alert idx_color_primary flex-not-logged-in-msg" id="box_flex_alerts_msg"><p>'. __("The Sub Area you requested is not available.", IDXBOOST_DOMAIN_THEME_LANG).'</p></div></div>';
        }

        $search_params = $flex_idx_info['search'];

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';
        $default_floor_plan=[];
        
        if (is_array($flex_idx_info) && count($flex_idx_info)>0) {
            
            if ( array_key_exists('default_floor_plan',$flex_idx_info['search']) && !empty($flex_idx_info['search']['default_floor_plan'])) {
                if (!is_array($flex_idx_info['search']['default_floor_plan'])) {
                    $default_floor_plan=@json_decode($flex_idx_info['search']['default_floor_plan'],true);
                }
                

            }
        }

        ob_start();

                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_sub_area.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_sub_area.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/flex_idx_sub_area.php';
                }

        return ob_get_clean();
    }

    add_shortcode('flex_idx_sub_area', 'flex_idx_sub_area_sc');
}

if (!function_exists('flex_idx_off_market_listings_sc')) {
    function flex_idx_off_market_listings_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'token_id' => '',
            'mode'        => 'default',
        ), $atts);

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $atts['token_id'],
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_LOOKUP_OFF_MARKET_LISTING);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        /*
        var_dump($server_output);
        die();
        */
        curl_close($ch);

        $response = json_decode($server_output, true);

        $current_url = home_url($wp_request);
        $property    = (isset($response['success']) && $response['success'] === true) ? $response['payload'] : array();

        wp_enqueue_script('flex-idx-property-js');

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';


        // build facebook url share
        $site_title = get_bloginfo('name');
        $property_permalink=$current_url;
        $facebook_share_url    = '//www.facebook.com/sharer/sharer.php';
        @$facebook_share_params = http_build_query(array(
            'u'           => $$current_url,
            'picture'     => $property['gallery'][0],
            'title'       => $property['address'],
            'caption'     => $site_title,
            'description' => $property['descriptionEspe'],
        ));

        $facebook_share_url .= '?' . $facebook_share_params;

        // build twitter url share
        $twitter_text = $property['address'];



        $twitter_share_url_params = http_build_query(array(
            'text' => $twitter_text,
            'url'  => $current_url,
        ));

                $twitter_share_url = 'https://twitter.com/intent/tweet?' . $twitter_share_url_params;

                $agent_info = get_option('idxboost_agent_info');
                $registration_is_forced = (isset($agent_info["force_registration"]) && (true === $agent_info["force_registration"])) ? true : false;

        ob_start();

                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_off_market_listing_detail.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idx_off_market_listing_detail.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idx_off_market_listing_detail.php';
                }

        return ob_get_clean();
    }

    add_shortcode('flex_idx_off_market_listing', 'flex_idx_off_market_listings_sc');
}




if (!function_exists('idxboost_sub_area_inventory_sc')) {
    function idxboost_sub_area_inventory_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'building_id' => '',
            'type'        => 'all',
            'title'        => '',
            'template'        => 'defaut',
            'sub_title'        => '',
            'button_title' => 'show',
            'mode'        => 'default',
            'load'        => 'default',
            'sockets'        => 'off',
            'limit'        => 'default',
            'view'        => 'grid',
        ), $atts);

        $type_view=$atts['type'];
        $type_view_default=$atts['view'];

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $atts['building_id'],
            'access_token'     => $access_token,
            'limit'        => $atts['limit'],
            'mode_view'        => $atts['mode'],
            'flex_credentials' => $flex_lead_credentials
        );

        if ($atts['button_title']=='hide') {
            $text_button_style='style="display: none;"';
        }
        
        wp_enqueue_style('flex-idx-filter-pages-css');

        wp_localize_script('flex-idx-sub-area-inventory-js', 'ib_building_inventory', ['param'=>$sendParams,'load_item'=> $atts['load']] );

        add_action('wp_footer', 'ib_tables_sub_area_collection');

        if ($atts['load'] !='ajax') {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SUB_AREA_COLLECTION_LOOKUP);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

            $server_output = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($server_output, true);            
        }

        $search_params = $flex_idx_info['search'];

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';

        ob_start();

        if ($atts['load'] =='ajax') {
            if($atts['mode']=='thumb'){
                include FLEX_IDX_PATH . '/views/shortcode/thumb_idxboost_sub_area_collection_ajax.php';
            } else if ($atts['template'] == "detail-collection" ) {
                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_sub_area_detail_collection.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_sub_area_detail_collection.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idxboost_sub_area_detail_collection.php';
                }                
            }else{
                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_sub_area_collection_ajax.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_sub_area_collection_ajax.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idxboost_sub_area_collection_ajax.php';
                }
            }

        }else{
            if($atts['mode']=='thumb'){
                include FLEX_IDX_PATH . '/views/shortcode/thumb_idxboost_sub_area_collection.php';
            }else{
                    if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_sub_area_collection.php')) {
                        include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_sub_area_collection.php';
                    } else {
                        include FLEX_IDX_PATH . '/views/shortcode/idxboost_sub_area_collection.php';
                    }
            }
        }


        return ob_get_clean();
    }

    add_shortcode('idxboost_sub_area_inventory', 'idxboost_sub_area_inventory_sc');
}


if (!function_exists('idxboost_building_inventory_sc')) {
    function idxboost_building_inventory_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'building_id' => '',
            'type'        => 'all',
            'title'        => '',
            'sub_title'        => '',
            'button_title' => 'show',
            'mode'        => 'default',
            'load'        => 'default',
            'limit'        => 'default',
            'view'        => 'grid',
        ), $atts);

        $type_view=$atts['type'];
        $type_view_default=$atts['view'];

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $atts['building_id'],
            'access_token'     => $access_token,
            'limit'        => $atts['limit'],
            'mode_view'        => $atts['mode'],
            'flex_credentials' => $flex_lead_credentials
        );

        if ($atts['button_title']=='hide') {
            $text_button_style='style="display: none;"';
        }
        
        wp_enqueue_style('flex-idx-filter-pages-css');

        wp_localize_script('flex-idx-building-inventory-js', 'ib_building_inventory', ['param'=>$sendParams,'load_item'=> $atts['load']] );

        add_action('wp_footer', 'ib_tables_building_collection');

        if ($atts['load'] !='ajax') {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDING_COLLECTION_LOOKUP);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

            $server_output = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($server_output, true);            
        }

        /*only show in no script*/
        $result_data_collection_get=get_feed_file_building_history_building_xhr_fn($atts['building_id']);
        if (!empty($result_data_collection_get)) {
            $result_data_collection=json_decode($result_data_collection_get,true);
        }
        /*only show in no script*/

        $search_params = $flex_idx_info['search'];

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';

        ob_start();

        if ($atts['load'] =='ajax') {
            if($atts['mode']=='thumb'){
                include FLEX_IDX_PATH . '/views/shortcode/thumb_idxboost_building_collection_ajax.php';
            }else{
                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_collection_ajax.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_collection_ajax.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idxboost_building_collection_ajax.php';
                }
            }

        }else{
            if($atts['mode']=='thumb'){
                include FLEX_IDX_PATH . '/views/shortcode/thumb_idxboost_building_collection.php';
            }else{
                    if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_collection.php')) {
                        include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_collection.php';
                    } else {
                        include FLEX_IDX_PATH . '/views/shortcode/idxboost_building_collection.php';
                    }
            }
        }


        return ob_get_clean();
    }

    add_shortcode('idxboost_building_inventory', 'idxboost_building_inventory_sc');
}

if (!function_exists('idxboost_building_history_count_sc')) {
    function idxboost_building_history_count_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'building_id' => '',
            'type'        => 'default',
        ), $atts);

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $atts['building_id'],
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        wp_enqueue_style('flex-idx-filter-pages-css');
        wp_enqueue_script('flex-idx-building-inventory-js');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDING_COLLECTION_LOOKUP);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($server_output, true);
        //$response = json_decode('', true);

        $search_params = $flex_idx_info['search'];

        $agent_info_name  = isset($flex_idx_info['agent']['agent_contact_first_name']) ? $flex_idx_info['agent']['agent_contact_first_name'] : '';
        $agent_last_name  = isset($flex_idx_info['agent']['agent_contact_last_name']) ? $flex_idx_info['agent']['agent_contact_last_name'] : '';
        $agent_info_photo = isset($flex_idx_info['agent']['agent_contact_photo_profile']) ? $flex_idx_info['agent']['agent_contact_photo_profile'] : '';
        $agent_info_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? $flex_idx_info['agent']['agent_contact_phone_number'] : '';
        $agent_info_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? $flex_idx_info['agent']['agent_contact_email_address'] : '';

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_history_count.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost_building_history_count.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/idxboost_building_history_count.php';
				}

        return ob_get_clean();
    }

    add_shortcode('idxboost_building_history_count', 'idxboost_building_history_count_sc');
}


if (!function_exists('idx_buildind_group_sc')) {
    function idx_buildind_group_sc($atts)
    {
        global $wp, $wpdb, $flex_idx_info;

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        $atts = shortcode_atts(array(
            'building_id' => '',
            'mode'        => 'default',
            'class'        => ' ',
            'type_view'        => 'grid',
            'limit'        => 'default',
        ), $atts);

        $access_token          = flex_idx_get_access_token();
        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        $sendParams = array(
            'filter_id'        => $atts['building_id'],
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        wp_enqueue_style('flex-idx-filter-pages-css');
        wp_enqueue_script('flex-idx-building-js');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_BUILDING_GROUP_LOOKUP);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_building_group.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_building_group.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_building_group.php';
				}

        return ob_get_clean();
    }

    add_shortcode('idx_buildind_group', 'idx_buildind_group_sc');
    add_shortcode('idx_building_group', 'idx_buildind_group_sc');
}


if (!function_exists('flex_idx_profile_sc')) {
    function flex_idx_profile_sc($atts, $content = null)
    {
        global $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        wp_enqueue_style('dgt-flex-listing-save-profile-css');
        wp_enqueue_script('flex-idx-profile');

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_profile.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_profile.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_profile.php';
				}

        return ob_get_clean();
    }

    add_shortcode('flex_idx_profile', 'flex_idx_profile_sc');
}

if (!function_exists('flex_idx_favorites_sc')) {
    function flex_idx_favorites_sc($atts, $content = null)
    {
        global $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();
        $search_params = $flex_idx_info['search'];

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        wp_enqueue_style('flex-favorites-css');
        wp_enqueue_script('flex-idx-saved-listing');

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_FAVORITES_LIST);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_favorites.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_favorites.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_favorites.php';
				}

        return ob_get_clean();
    }

    add_shortcode('flex_idx_favorites', 'flex_idx_favorites_sc');
}

if (!function_exists('flex_idx_saved_searches_sc')) {
    function flex_idx_saved_searches_sc($atts, $content = null)
    {
        global $wpdb, $flex_idx_info, $flex_idx_lead;

        $access_token          = flex_idx_get_access_token();

        if (get_option('idxboost_client_status') != 'active') {
            return '<div class="clidxboost-msg-info"><strong>Please update your API key</strong> on your IDX Boost dashboard to display live MLS data. <a href="' . FLEX_IDX_CPANEL_URL . '" rel="nofollow">Click here to update</a></div>';
        }

        wp_enqueue_style('dgt-flex-listing-save-profile-css');
        wp_enqueue_script('flex-idx-saved-searches');
        
        // wp_enqueue_script('flex-idx-saved-searches-js');

        $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

        $sendParams = array(
            'access_token'     => $access_token,
            'flex_credentials' => $flex_lead_credentials
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_SAVED_SEARCHES_LIST);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        $saved_searches = (isset($response['success']) && $response['success'] === true) ? $response['items'] : array();

        ob_start();

				if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_saved_searches.php')) {
					include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/flex_idx_saved_searches.php';
				} else {
					include FLEX_IDX_PATH . '/views/shortcode/flex_idx_saved_searches.php';
				}

        return ob_get_clean();
    }

    add_shortcode('flex_idx_saved_searches', 'flex_idx_saved_searches_sc');
}

if (!function_exists('idxboost_menu_dynamic_sc')) {
    function idxboost_menu_dynamic_sc($atts, $content = null)
    {
        global $wpdb, $flex_idx_info, $flex_idx_lead;

       ob_start();

                if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost-menu-dynamic.php')) {
                    include IDXBOOST_OVERRIDE_DIR . '/views/shortcode/idxboost-menu-dynamic.php';
                } else {
                    include FLEX_IDX_PATH . '/views/shortcode/idxboost-menu-dynamic.php';
                }

        return ob_get_clean();
    }

    add_shortcode('idxboost_menu', 'idxboost_menu_dynamic_sc');
}


if (!function_exists('shortcode_upload_fr')) {
    function shortcode_upload_fr($atts, $content = null)
    {
        global $wpdb;
        $atts = shortcode_atts(array('id_package' => '0','registration_key' => '0','environment' => 'staging'), $atts);
       ob_start();

       $response=[];
        $response_neighborhood=idx_download_neighborhood($atts['id_package'],$atts['registration_key'],$atts['environment']);
        $response_community=idx_download_community($atts['id_package'],$atts['registration_key'],$atts['environment']);
        $response_building=idx_download_building($atts['id_package'],$atts['registration_key'],$atts['environment']);
        
        $response=[
            'neighborhood' => $response_neighborhood,
            'community' => $response_community,
            'building' => $response_building
        ];

        var_dump($response);

        return ob_get_clean();
    }

    add_shortcode('shortcode_upload', 'shortcode_upload_fr');
}


if (!function_exists('idx_download_neighborhood')){
    function idx_download_neighborhood($id_package ='0', $registration_key = '0',$environment = 'staging') {
        if (empty($registration_key) || empty($id_package) || empty($environment) ) {
            return new JsonResponse(['status'=>false,'message'=>'Invalid Parameters' ]);
        }
        global $wpdb;
        ob_start();
        $current_user_id = get_current_user_id();
        $ch = curl_init();
        $sendParams=array('id_package' => $id_package,'registration_key' => $registration_key,'environment' => $environment );
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_BACKOFFICE_CPANEL_URL.'/tgapi/feed_automatic_neighborhood');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        if ( array_key_exists('status', $response) && $response['status']==false) {
            return ['status'=>false,'message'=>'No found data','message_server' => $response['message'] ];
        }

        $estruct_insert_page="INSERT INTO wp_posts(post_title,post_content,post_type,post_status,post_mime_type,post_name) values";
        $estruct_insert="INSERT INTO wp_posts(post_title,post_type,post_status,post_mime_type) values";
        $estruct_insert_silo="INSERT INTO wp_posts(post_title,post_type,post_status,post_mime_type) values";

        $wp_postmeta_insert="INSERT INTO wp_postmeta(post_id,meta_key,meta_value) values";
        
        $insert_values=[]; $insert_values_pages=[]; $values_metas=[];
        $array_neigh=[];

    foreach ($response as $key_neigh => $value_neigh) {
        $array_filter_neig=[];
        $id=$value_neigh['id'];
        $name=$value_neigh['name'];
        $address=$value_neigh['address'];
        $lat=$value_neigh['lat'];
        $lng=$value_neigh['lng'];
        $klm=$value_neigh['klm'];
        $array_filter_neig=$value_neigh['tokens_list'];
        

        if (!empty($name)) {
            $insert_values[]="('".$name."','neighborhood','publish','".$id."')";
            $insert_values_pages[]="('".$name."','".addslashes('[flex_idx_filter id="'.$array_filter_neig['general'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name)."')";
            
            if( array_key_exists('homes_for_sale', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Homes For Sale','".addslashes('[flex_idx_filter id="'.$array_filter_neig['homes_for_sale'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Homes For Sale")."')";
            }
            if( array_key_exists('condos_for_sale', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Condos For Sale','".addslashes('[flex_idx_filter id="'.$array_filter_neig['condos_for_sale'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Condos For Sale")."')";
            }
            if( array_key_exists('homes_for_rent', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Homes for Rent','".addslashes('[flex_idx_filter id="'.$array_filter_neig['homes_for_rent'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Homes for Rent")."')";
            }
            
            if( array_key_exists('apartments_for_rent', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Apartments for Rent','".addslashes('[flex_idx_filter id="'.$array_filter_neig['apartments_for_rent'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Apartments for Rent")."')";
            }

            if( array_key_exists('vacant_land_sale', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Land & Vacant Lots','".addslashes('[flex_idx_filter id="'.$array_filter_neig['vacant_land_sale'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Land & Vacant Lots")."')";
            }

            if( array_key_exists('vacant_land_rent', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Vacant Land for Rent','".addslashes('[flex_idx_filter id="'.$array_filter_neig['vacant_land_rent'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Vacant Land for Rent")."')";
            }


            /*nuevos campos*/
            if( array_key_exists('waterfront_homes', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Waterfront Homes','".addslashes('[flex_idx_filter id="'.$array_filter_neig['waterfront_homes'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Waterfront Homes")."')";
            }

            if( array_key_exists('gated_communities', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Gated Communities','".addslashes('[flex_idx_filter id="'.$array_filter_neig['gated_communities'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Gated Communities")."')";
            }

            if( array_key_exists('new_construction', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." New Construction','".addslashes('[flex_idx_filter id="'.$array_filter_neig['new_construction'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." New Construction")."')";
            }

            if( array_key_exists('townhomes_villas', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Townhomes & Villas','".addslashes('[flex_idx_filter id="'.$array_filter_neig['townhomes_villas'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Townhomes & Villas")."')";
            }

            if( array_key_exists('luxury_waterfront_condos', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Luxury & Waterfront Condos','".addslashes('[flex_idx_filter id="'.$array_filter_neig['luxury_waterfront_condos'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Luxury & Waterfront Condos")."')";
            }

            if( array_key_exists('home_condo_rentals', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Home and Condo Rentals','".addslashes('[flex_idx_filter id="'.$array_filter_neig['home_condo_rentals'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Home and Condo Rentals")."')";
            }

            if( array_key_exists('short_sales', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Short Sales','".addslashes('[flex_idx_filter id="'.$array_filter_neig['short_sales'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Short Sales")."')";
            }

            if( array_key_exists('foreclosures', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Foreclosures','".addslashes('[flex_idx_filter id="'.$array_filter_neig['foreclosures'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Foreclosures")."')";
            }
            /*nuevos campos*/

            $array_neigh[]=array('id' =>$id ,'name'=> $name,'address' => $address, 'lat'=> $lat,'lng'=> $lng,'klm'=> addslashes($klm) ,'tokens_list' => $value_neigh['tokens_list'] );
        }
    }

      $result_pages=$wpdb->query($estruct_insert_page.implode(',', $insert_values_pages));
      $result_post_type=$wpdb->query($estruct_insert.implode(',', $insert_values));    

      $result_item_neig=$wpdb->get_results("SELECT wp_posts.ID as id_neig,post_relation.ID as id_page,wp_posts.post_mime_type,post_relation.post_title FROM wp_posts INNER JOIN wp_posts as post_relation on post_relation.post_type='page' and post_relation.post_mime_type=wp_posts.post_mime_type where wp_posts.post_type='neighborhood';");

      $items_silos=[];

      foreach ($result_item_neig as $value_silo) {
        $link_association='';
        foreach ($array_neigh as $value_neig) {
            if ($value_neig['id']==$value_silo->post_mime_type) {         
                $address=$value_neig['address'];
                $lat=$value_neig['lat'];
                $lng=$value_neig['lng'];
                $klm=$value_neig['klm'];
                $link_association=$value_neig['name'];
                break;
            }
        }

        $key_exist = array_search($value_silo->id_neig, array_column($items_silos, 'id_page'));
        $id_temp=$value_silo->id_neig;
        $data_page=[];

        if (is_numeric($key_exist) != false) {          
            array_push($items_silos[$key_exist]['data'],array("id"=>$value_silo->id_page,"label"=>addslashes($value_silo->post_title),"post_type"=>"page"));
        }else{
            $data_arrray=[];
            $data_arrray[]=array("id"=>$value_silo->id_page,"label"=>addslashes($value_silo->post_title),"post_type"=>"page");
            $items_silos[]=array('id_page' => $id_temp,'id_page_post' => $value_silo->id_page , 'data' => $data_arrray );
            //INSERTACION POSTMETAS
            $values_metas[]="('".$value_silo->id_neig."','neighborhood_url','".get_site_url().'/'.generar_url_temp($link_association)."')";
            $values_metas[]="('".$value_silo->id_neig."','dgt_extra_address','".$address."')";      
            $values_metas[]="('".$value_silo->id_neig."','dgt_extra_lng','".$lng."')";      
            $values_metas[]="('".$value_silo->id_neig."','dgt_extra_lat','".$lat."')";      
            $values_metas[]="('".$value_silo->id_neig."','dgt_map_geometry','".$klm."')";       
            $values_metas[]="('".$value_silo->id_neig."','tgpost_relacion','".$value_silo->id_page."')";

        }
        $values_metas[]="('".$value_silo->id_page."','_wp_page_template','flex-page-neighborhood-detail-silo.php')";        
      }

      $textquery_metas=implode(',', $values_metas);
          $insert_query_metas=$wp_postmeta_insert.$textquery_metas;   
          $result_metas=$wpdb->query($insert_query_metas);

          foreach ($items_silos as $value_add_silo) {
             foreach ($value_add_silo['data'] as $value_parent) {
                if ($value_add_silo['id_page_post'] != $value_parent['id']) {
                    $wpdb->query("UPDATE wp_posts SET post_parent='".$value_add_silo['id_page_post']."' WHERE  ID='".$value_parent['id']."';");    
                }
            }

                $wp_insert_silo =  wp_insert_post(array(
                'post_title'   => $value_add_silo['id_page'],
                'post_content' => json_encode($value_add_silo['data'],true),
                'post_status'  => 'inherit',
                'post_author'  => '2',
                'post_type'    => 'idxboost-silo'
            ));        
          }
          return ['status'=>true,'message'=>'Upload susscess','data'=>$array_neigh ];
    }
}




if (!function_exists('idx_download_community')){
    function idx_download_community($id_package ='0', $registration_key = '0',$environment = 'staging') {
        if (empty($registration_key) || empty($id_package) || empty($environment) ) {
            return new JsonResponse(['status'=>false,'message'=>'Invalid Parameters' ]);
        }

        global $wpdb;
        ob_start();
        $current_user_id = get_current_user_id();
        $ch = curl_init();
        $sendParams=array('id_package' => $id_package,'registration_key' => $registration_key,'environment' => $environment );
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_BACKOFFICE_CPANEL_URL.'/tgapi/feed_automatic_community');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        if ( array_key_exists('status', $response) && $response['status']==false) {
            return ['status'=>false,'message'=>'No found data','message_server' => $response['message'] ];
        }

        $estruct_insert_page="INSERT INTO wp_posts(post_title,post_content,post_type,post_status,post_mime_type,post_name,post_parent) values";
        $estruct_insert="INSERT INTO wp_posts(post_title,post_type,post_status,post_mime_type) values";
        $estruct_insert_silo="INSERT INTO wp_posts(post_title,post_type,post_status,post_mime_type) values";

        $wp_postmeta_insert="INSERT INTO wp_postmeta(post_id,meta_key,meta_value) values";
        
      $items_neighborhood=$wpdb->get_results("SELECT ID,post_title,post_mime_type,wp_postmeta.meta_value as page_wp FROM wp_posts left join wp_postmeta on wp_postmeta.post_id=wp_posts.ID and wp_postmeta.meta_key='tgpost_relacion' where post_type='neighborhood' and post_status='publish';",ARRAY_A);

        $insert_values=[]; $insert_values_pages=[]; $values_metas=[];
        $array_neigh=[];

    foreach ($response as $key_neigh => $value_neigh) {
        $array_filter_neig=[];
        $id=$value_neigh['id'];
        $name=$value_neigh['name'];
        $address=$value_neigh['address'];
        $lat=$value_neigh['lat'];
        $lng=$value_neigh['lng'];
        $klm=$value_neigh['klm'];
        $idneigbordhood=$value_neigh['idNeighborhood'];
        $array_filter_neig=$value_neigh['tokens_list'];
        
        $exist_relation_neighborhood = array_search($idneigbordhood, array_column($items_neighborhood, 'post_mime_type'));

        $id_neighboarhood_relation=0;
        if (is_numeric($exist_relation_neighborhood)) {
            $id_neighboarhood_relation=$items_neighborhood[$exist_relation_neighborhood]['page_wp'];
        }

        if (!empty($name)) {
            $insert_values[]="('".$name."','communities','publish','".$id."')";
            $insert_values_pages[]="('".$name."','".addslashes('[flex_idx_filter id="'.$array_filter_neig['general'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name)."','".$id_neighboarhood_relation."')";
            
            if( array_key_exists('homes_for_sale', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Homes For Sale','".addslashes('[flex_idx_filter id="'.$array_filter_neig['homes_for_sale'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Homes For Sale")."','".$id_neighboarhood_relation."')";
            }
            if( array_key_exists('condos_for_sale', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Condos For Sale','".addslashes('[flex_idx_filter id="'.$array_filter_neig['condos_for_sale'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Condos For Sale")."','".$id_neighboarhood_relation."')";
            }
            if( array_key_exists('homes_for_rent', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Homes for Rent','".addslashes('[flex_idx_filter id="'.$array_filter_neig['homes_for_rent'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Homes for Rent")."','".$id_neighboarhood_relation."')";
            }
            if( array_key_exists('apartments_for_rent', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Apartments for Rent','".addslashes('[flex_idx_filter id="'.$array_filter_neig['apartments_for_rent'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Apartments for Rent")."','".$id_neighboarhood_relation."')";
            }

            if( array_key_exists('vacant_land_sale', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Land & Vacant Lots','".addslashes('[flex_idx_filter id="'.$array_filter_neig['vacant_land_sale'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Land & Vacant Lots")."','".$id_neighboarhood_relation."')";
            }

            if( array_key_exists('vacant_land_rent', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Vacant Land for Rent','".addslashes('[flex_idx_filter id="'.$array_filter_neig['vacant_land_rent'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Vacant Land for Rent")."','".$id_neighboarhood_relation."')";
            }  

            /*nuevos campos*/
            if( array_key_exists('waterfront_homes', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Waterfront Homes','".addslashes('[flex_idx_filter id="'.$array_filter_neig['waterfront_homes'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Waterfront Homes")."','".$id_neighboarhood_relation."')";
            }

            if( array_key_exists('gated_communities', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Gated Communities','".addslashes('[flex_idx_filter id="'.$array_filter_neig['gated_communities'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Gated Communities")."','".$id_neighboarhood_relation."')";
            }

            if( array_key_exists('new_construction', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." New Construction','".addslashes('[flex_idx_filter id="'.$array_filter_neig['new_construction'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." New Construction")."','".$id_neighboarhood_relation."')";
            }

            if( array_key_exists('townhomes_villas', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Townhomes & Villas','".addslashes('[flex_idx_filter id="'.$array_filter_neig['townhomes_villas'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Townhomes & Villas")."','".$id_neighboarhood_relation."')";
            }

            if( array_key_exists('luxury_waterfront_condos', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Luxury & Waterfront Condos','".addslashes('[flex_idx_filter id="'.$array_filter_neig['luxury_waterfront_condos'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Luxury & Waterfront Condos")."','".$id_neighboarhood_relation."')";
            }

            if( array_key_exists('home_condo_rentals', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Home and Condo Rentals','".addslashes('[flex_idx_filter id="'.$array_filter_neig['home_condo_rentals'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Home and Condo Rentals")."','".$id_neighboarhood_relation."')";
            }

            if( array_key_exists('short_sales', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Short Sales','".addslashes('[flex_idx_filter id="'.$array_filter_neig['short_sales'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Short Sales")."','".$id_neighboarhood_relation."')";
            }

            if( array_key_exists('foreclosures', $array_filter_neig) ) {
                $insert_values_pages[]="('".$name." Foreclosures','".addslashes('[flex_idx_filter id="'.$array_filter_neig['foreclosures'].'" type="3"]')."','page','publish','".$id."','".generar_url_temp($name." Foreclosures")."','".$id_neighboarhood_relation."')";
            }
            /*nuevos campos*/

            $array_neigh[]=array('id' =>$id ,'name'=> $name,'address' => $address, 'lat'=> $lat,'lng'=> $lng,'klm'=> addslashes($klm), 'id_neighboarhood' => $idneigbordhood ,'tokens_list' => $value_neigh['tokens_list'] );
        }
    }

      $result_pages=$wpdb->query($estruct_insert_page.implode(',', $insert_values_pages));
      $result_post_type=$wpdb->query($estruct_insert.implode(',', $insert_values));    

      $result_item_neig=$wpdb->get_results("SELECT wp_posts.ID as id_neig,post_relation.ID as id_page,wp_posts.post_mime_type,post_relation.post_title FROM wp_posts INNER JOIN wp_posts as post_relation on post_relation.post_type='page' and post_relation.post_mime_type=wp_posts.post_mime_type where wp_posts.post_type='communities';");

      $items_silos=[];

      foreach ($result_item_neig as $value_silo) {
        $link_association='';
        foreach ($array_neigh as $value_neig) {
            if ($value_neig['id']==$value_silo->post_mime_type) {         
                $address=$value_neig['address'];
                $lat=$value_neig['lat'];
                $lng=$value_neig['lng'];
                $klm=$value_neig['klm'];
                $link_association=$value_neig['name'];
                $key_exist_neighbo = array_search($value_neig['id_neighboarhood'], array_column($items_neighborhood, 'post_mime_type'));
                break;
            }
        }

        $key_exist = array_search($value_silo->id_neig, array_column($items_silos, 'id_page'));
        $id_temp=$value_silo->id_neig;
        $data_page=[];

        if (is_numeric($key_exist) != false) {          
            array_push($items_silos[$key_exist]['data'],array("id"=>$value_silo->id_page,"label"=>addslashes($value_silo->post_title),"post_type"=>"page"));
        }else{
            $data_arrray=[];
            $data_arrray[]=array("id"=>$value_silo->id_page,"label"=>addslashes($value_silo->post_title),"post_type"=>"page");
            $items_silos[]=array('id_page' => $id_temp,'id_page_post' => $value_silo->id_page , 'data' => $data_arrray );
            //INSERTACION POSTMETAS
            $values_metas[]="('".$value_silo->id_neig."','neighborhood_url','".get_site_url().'/'.generar_url_temp($link_association)."')";
            $values_metas[]="('".$value_silo->id_neig."','dgt_extra_address','".$address."')";      
            $values_metas[]="('".$value_silo->id_neig."','dgt_extra_lng','".$lng."')";      
            $values_metas[]="('".$value_silo->id_neig."','dgt_extra_lat','".$lat."')";      
            $values_metas[]="('".$value_silo->id_neig."','dgt_map_geometry','".$klm."')";       
            $values_metas[]="('".$value_silo->id_neig."','tgpost_relacion','".$value_silo->id_page."')";
            $values_metas[]="('".$value_silo->id_neig."','tgpost_relacion_communitity','".$value_silo->id_page."')";
            if (is_numeric($key_exist_neighbo) ) {
                $values_metas[]="('".$value_silo->id_neig."','tgpost_relacion_neighborhood','".$items_neighborhood[$key_exist_neighbo]['ID']."')";
            }

        }
        $values_metas[]="('".$value_silo->id_page."','_wp_page_template','flex-page-communities-detail-silo.php')";        
      }

      $textquery_metas=implode(',', $values_metas);
          $insert_query_metas=$wp_postmeta_insert.$textquery_metas;   
          $result_metas=$wpdb->query($insert_query_metas);

          foreach ($items_silos as $value_add_silo) {
             foreach ($value_add_silo['data'] as $value_parent) {
                if ($value_add_silo['id_page_post'] != $value_parent['id']) {
                    $wpdb->query("UPDATE wp_posts SET post_parent='".$value_add_silo['id_page_post']."' WHERE  ID='".$value_parent['id']."';");    
                }
            }

                $wp_insert_silo =  wp_insert_post(array(
                'post_title'   => $value_add_silo['id_page'],
                'post_content' => json_encode($value_add_silo['data'],true),
                'post_status'  => 'inherit',
                'post_author'  => '2',
                'post_type'    => 'idxboost-silo'
            ));        
          }
          return ['status'=>true,'message'=>'Upload susscess','data'=>$array_neigh ];
    }
}




if (!function_exists('idx_download_building')){
    function idx_download_building($id_package ='0', $registration_key = '0',$environment = 'staging') {
        
        if (empty($registration_key) || empty($id_package) || empty($environment) ) {
            return new JsonResponse(['status'=>false,'message'=>'Invalid Parameters' ]);
        }

        global $wpdb;
        ob_start();
        $current_user_id = get_current_user_id();
        $estruct_insert_page="INSERT INTO wp_posts(post_title,post_type,post_status,post_mime_type,post_name) values";
        $wp_postmeta_insert="INSERT INTO wp_postmeta(post_id,meta_key,meta_value) values";
        $struct_table_relationship='INSERT into wp_term_relationships(object_id,term_taxonomy_id,term_order) values';

        $insert_values=[]; $insert_values_pages=[]; $values_metas=[]; $insert_pages_idxboost=[]; $insert_metas_idxboost=[]; $values_category=[];

       $categorys_loop = $wpdb->get_results("SELECT {$wpdb->terms}.slug,{$wpdb->terms}.term_id FROM {$wpdb->term_taxonomy} INNER JOIN {$wpdb->terms} ON {$wpdb->terms}.term_id={$wpdb->term_taxonomy}.term_id AND {$wpdb->term_taxonomy}.taxonomy='category_building';",ARRAY_A);   

        $ch = curl_init();
        $sendParams=array('id_package' => $id_package,'registration_key' => $registration_key,'environment' => $environment );
        curl_setopt($ch, CURLOPT_URL, FLEX_IDX_BACKOFFICE_CPANEL_URL.'/tgapi/feed_automatic_building');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());

        $server_output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($server_output, true);

        if ( array_key_exists('status', $response) && $response['status']==false) {
            return ['status'=>false,'message'=>'No found data','message_server' => $response['message'] ];
        }

        $array_building=[];

        foreach ($response as $user_mostrar) {
            $id=$user_mostrar['id'];
            $gallery=json_decode($user_mostrar['gallery'],true);
            $name=$user_mostrar['nameBuilding'];
            $address=$user_mostrar['addressBuilding'];
            $lat=$user_mostrar['lat'];
            $lng=$user_mostrar['lng'];
            $idNeighborhood=$user_mostrar['idNeighborhood'];
            $idCommunity=$user_mostrar['idCommunity'];
            $idCategoryBuilding=$user_mostrar['idCategoryBuilding'];
            $cod_buillding=$user_mostrar['cod_buillding'];
            $units=$user_mostrar['units'];
            $yearBuilding=$user_mostrar['yearBuilding'];
            $insert_values_pages[]="('".addslashes($name)."','tgbuilding','publish','".$id."','".generar_url_temp($name)."')";
            $insert_pages_idxboost[]="('".addslashes($name)."','flex-idx-building','publish','".$id."','".generar_url_temp($name)."')";

            $array_building[]=array('id' => $id ,'name' => $name ,'address' => $address, 'lat'=> $lat,'lng'=> $lng,'id_neighboarhood' => $idNeighborhood,'idCommunity'=>$idCommunity,'gallery'  => $gallery, 'year'=>$yearBuilding,'cod_buillding' => $cod_buillding, 'units' => $units,'category' => $idCategoryBuilding);
        }
        $result_pages=$wpdb->query($estruct_insert_page.implode(',', $insert_values_pages));

       ob_start();        

        $result_pages_build_wp=$wpdb->get_results("SELECT wp_posts.ID,wp_posts.post_title,wp_posts.post_mime_type FROM wp_posts where wp_posts.post_type='tgbuilding' and post_status='publish';");
        $items_neighborhood=$wpdb->get_results("SELECT ID,post_title,post_mime_type FROM wp_posts where post_type='neighborhood' and post_status='publish';",ARRAY_A);
        $items_communities=$wpdb->get_results("SELECT ID,post_title,post_mime_type FROM wp_posts where post_type='communities' and post_status='publish';",ARRAY_A);

        foreach ($result_pages_build_wp as $build_wp) {
            //$exist_building = array_search($build_wp->post_mime_type, array_column($array_building, 'id'));
            
            $gallery_tg='';
            $cod_buillding='';
            $name_buil=''; 
            $units='';
            foreach ($array_building as $exist_building) {
                if ($build_wp->post_mime_type == $exist_building['id']) {
                $address=$exist_building['address'];
                $lat=$exist_building['lat'];
                $lng=$exist_building['lng'];
                $name_buil=$exist_building['name'];
                $year=$exist_building['year'];
                $units=$exist_building['units'];
                $category=$exist_building['category'];
                
                $id_neighboarhood='';$idCommunity='';
                $cod_buillding=$exist_building['cod_buillding'];
                $key_exist_communi = array_search($exist_building['idCommunity'], array_column($items_communities, 'post_mime_type'));
                $key_exist_neighbo = array_search($exist_building['id_neighboarhood'], array_column($items_neighborhood, 'post_mime_type'));
                //break;    
                    if (count($exist_building['gallery'])>0) { 
                        $gallery_tg=$exist_building['gallery'][0];
                    }
                    /*cateogry*/
                    $building_category='complete-building';
                    if ($category=='2') {
                        $building_category='pre-construction';
                    }
                    $keys_category=array_search($building_category, array_column($categorys_loop, 'slug'));
                }
            }

                    if (is_numeric($keys_category) && array_key_exists($keys_category,$categorys_loop) ) {
                        $values_category[]="('".$build_wp->ID."','".$categorys_loop[$keys_category]['term_id']."','0')";      
                    }

            $values_metas[]="('".$build_wp->ID."','tgbuilding_url','".get_site_url().'/building/'.generar_url_temp($name_buil)."')";      
            $values_metas[]="('".$build_wp->ID."','dgt_extra_address','".$address."')";      
            $values_metas[]="('".$build_wp->ID."','dgt_extra_lat','".$lat."')";      
            $values_metas[]="('".$build_wp->ID."','dgt_extra_lng','".$lng."')";      
            $values_metas[]="('".$build_wp->ID."','dgt_year_building','".$year."')";      
            $values_metas[]="('".$build_wp->ID."','dgt_extra_unit','".$units."')";      
            $values_metas[]="('".$build_wp->ID."','dgt_tg_idxboost_building','".$cod_buillding."')";      
            $values_metas[]="('".$build_wp->ID."','dgt_tg_gallery','".$gallery_tg."')"; 
            $values_metas[]="('".$build_wp->ID."','dgt_tgid_neighnorhood','".$items_neighborhood[$key_exist_neighbo]['ID']."')";      
            $values_metas[]="('".$build_wp->ID."','dgt_tgid_community','".$items_communities[$key_exist_communi]['ID']."')";      
        }
        $result_metas=$wpdb->query($wp_postmeta_insert.implode(',', $values_metas));
        $query_insert_categories=$wpdb->query($struct_table_relationship.implode(',', $values_category));
        /*GUARDAR LOS RESULTADOS A LAS PAGINAS DE BUILDING DEL IDXBOOST POST TYPE flex-idx-building */
        $result_pages_idxboost=$wpdb->query($estruct_insert_page.implode(',', $insert_pages_idxboost));

        $result_idxboost_build_pa=$wpdb->get_results("SELECT wp_posts.ID,wp_posts.post_title,wp_posts.post_mime_type FROM wp_posts where wp_posts.post_type='flex-idx-building' and post_status='publish';");
        foreach ($result_idxboost_build_pa as $build_wp) {
            $cod_buillding='';
            
            foreach ($array_building as $exist_building) {
                if ($build_wp->post_mime_type == $exist_building['id']) {
                $cod_buillding=$exist_building['cod_buillding'];
                }
            }
            $insert_metas_idxboost[]="('".$build_wp->ID."','_flex_building_page_id','".$cod_buillding."')"; 
        }
        $result_metas_idxboost=$wpdb->query($wp_postmeta_insert.implode(',', $insert_metas_idxboost));
        /*GUARDAR LOS RESULTADOS A LAS PAGINAS DE BUILDING DEL IDXBOOST POST TYPE flex-idx-building */
        return ['status'=>true,'message'=>'Upload susscess','data'=>$array_building ];
    }
}



function generar_url_temp($cadena) {
$separador = '-';//ejemplo utilizado con guión medio
$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
 
//Quitamos todos los posibles acentos
$url = strtr(utf8_decode($cadena), utf8_decode($originales), $modificadas);
 
//Convertimos la cadena a minusculas
$url = utf8_encode(strtolower($url));
 
//Quitamos los saltos de linea y cuanquier caracter especial
$buscar = array(' ', '&amp;', '\r\n', '\n', '+', '&');
$url = str_replace ($buscar, $separador, $url);
$buscar = array('/[^a-z0-9\-&lt;&gt;]/', '/[\-]+/', '/&lt;[^&gt;]*&gt;/');
$reemplazar = array('', $separador, '');
$url = preg_replace ($buscar, $reemplazar, $url);
return $url;
}