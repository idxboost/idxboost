	<?php  if ( is_array($responseParms) && count($responseParms) > 0) { ?>
<script>
	var IB_IS_SEARCH_FILTER_PAGE = true;
  var IB_SEARCH_FILTER_PAGE = true;
  var IB_SEARCH_FILTER_PAGE_TITLE = '<?php the_title(); ?>';

  jQuery(function() {
    if (true === IB_SEARCH_FILTER_PAGE) {
      jQuery('#formRegister').append('<input type="hidden" name="source_registration_title" value="' + IB_SEARCH_FILTER_PAGE_TITLE + '">');
      jQuery('#formRegister').append('<input type="hidden" name="source_registration_url" value="' + location.href + '">');
      jQuery("#formRegister_ib_tags").val(IB_SEARCH_FILTER_PAGE_TITLE);
    }
  });
</script>

<?php  } ?>

<?php
	$idxboost_search_settings = get_option('idxboost_search_settings');
	$idxboost_search_filter_settings = get_option('idxboost_search_filter_settings');
	$idxboost_agent_info = get_option('idxboost_agent_info');
	$api_idx_access_token = flex_idx_get_access_token();
	$ia_search = ( array_key_exists("ia_search", $flex_idx_info["agent"] ) && !empty($flex_idx_info["agent"]["ia_search"]) ) ? $flex_idx_info["agent"]["ia_search"] : '0';
?>
<script>
	//var localURL = '<?php echo get_stylesheet_directory_uri(); ?>/shortcode/idx-search/';
	var __flex_g_settings = {
		propertyDetailPermalink: '<?php echo get_site_url(); ?>/property'
	}

	<?php 
	//var_dump($flex_idx_info["agent"]["force_registration"]);
	//var_dump($idxboost_agent_info['force_registration_forced']);
	
		$force_registration = isset($flex_idx_info["agent"]["force_registration"]) ? $flex_idx_info["agent"]["force_registration"] : 0;
	 	$force_registration_forced =  ($force_registration == "1") ?  $idxboost_agent_info['force_registration_forced'] : null;
		$signup_left_clicks = ( $force_registration == "1" &&  isset($flex_idx_info["agent"]["signup_left_clicks"]) && !empty($flex_idx_info["agent"]["signup_left_clicks"]) ? (int)$flex_idx_info["agent"]["signup_left_clicks"] : 0); 
	
	//var_dump($force_registration_forced);
	?>


	window.idx_main_settings = {
		paths: '<?php echo FLEX_IDX_URI."react/new_search_filter/"; ?>',
		mode : '<?php echo $atts["mode"]; ?>',
		is_commercial: '<?php echo $atts["is_commercial"]; ?>',
		oh : '<?php echo $atts["oh"]; ?>',
		link : '<?php echo $atts["link"]; ?>',
		title : '<?php echo $atts["title"]; ?>',
		gallery : '<?php echo $atts["gallery"]; ?>',
		name_button : '<?php echo $atts["name_button"]; ?>',
		slider_item : '<?php echo $atts["slider_item"]; ?>',
		limit : '<?php echo $atts["limit"]; ?>',
		saveListings : '<?php echo FLEX_IDX_API_SEARCH_FILTER_SAVE; ?>',
		rk : '<?php echo get_option('flex_idx_alerts_keys'); ?>',
		wp_web_id : '<?php echo get_option('flex_idx_alerts_app_id'); ?>',
		active_ai : '<?php echo $ia_search; ?>',

		

		force_registration: Boolean(<?php echo $force_registration; ?>),
		force_registration_forced: <?php echo  $force_registration == "1" ? json_encode($force_registration_forced) : "undefined"; ?>,
		signup_left_clicks: <?php echo  $force_registration == "1" ? $signup_left_clicks : "undefined"; ?>,

		search_settings:<?php
		if ( !empty($atts["filter_id"]) )
			echo json_encode(array_merge($flex_idx_info['search'], is_array($flex_idx_info['search_filter_settings']) ? $flex_idx_info['search_filter_settings'] : []));
		else
		 echo json_encode($idxboost_search_settings); ?>,
		
		//search_filter_settings:<?php echo json_encode($idxboost_search_filter_settings); ?>,
		agent_info:<?php echo json_encode($idxboost_agent_info); ?>,
		access_token:"<?php echo $api_idx_access_token; ?>",
		board_info : <?php echo @json_encode($idxboost_search_settings['board_info']); ?>
	}	
	window.idxtoken="<?php echo $access_token_service; ?>";

	<?php 
	if ( is_array($responseParms) && count($responseParms) > 0) {
		echo 'window.paramsMapSearch = '. json_encode($responseParms);
	}?>
</script>  


  <!-- JS 
  <script type="module" crossorigin src="<?php echo get_stylesheet_directory_uri(); ?>/shortcode/idx-search/assets/index-BsLADlot.js"></script>
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/shortcode/idx-search/assets/index-Ys-jX6yu.css" />
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/shortcode/idx-search/fonts/icons/style.css" />
  <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU6VY2oHfII-RPAcZZu9qq843bpE3pLNo&libraries=drawing,marker,geometry"></script>
 GOOGLE MAP -->

<div id="root-search"></div>

<script type="text/javascript">

function saveFilterSearchForLead() {

        var search_url = location.href;
        if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
            var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
            if (pattern.test(initial_href)) {
                var search_url = initial_href;
            } else {
                var search_url = __flex_idx_search_filter_v2.searchFilterPermalink + initial_href;
            }
        }


        var search_count = window.idx_data_filter_alert.count;
        var search_condition = window.idx_data_filter_alert.condition;
        var search_name = IB_SEARCH_FILTER_PAGE_TITLE;
        var search_filter_params = window.idx_data_filter_alert.params;
        var search_filter_ID = '<?php echo $atts["id"]; ?>';

        if ("no" === __flex_g_settings.anonymous && (typeof search_filter_ID !== "undefined")) {
            jQuery.ajax({
                type: "POST",
                url: window.idx_main_settings.saveListings.replace(/{{filterId}}/g, search_filter_ID),
                data: {
                    access_token: window.idx_main_settings.access_token,
                    search_rk: window.idx_main_settings.rk,
                    search_wp_web_id: window.idx_main_settings.wp_web_id,
                    flex_credentials: Cookies.get("ib_lead_token"),
                    search_filter_id: search_filter_ID,
                    search_url: search_url,
                    search_count: search_count,
                    search_condition: search_condition,
                    search_name: search_name,
                    version: 2,
                    search_params: (search_filter_params)
                },
                success: function (response) {
                    // console.log("The search filter has been saved successfully.");
                }
            });
        }
    }	
</script>

<?php if($atts["mode"] == "slider"){ ?>
<script type="module" crossorigin src="<?php echo FLEX_IDX_URI . 'react/shortcode_slider/assets/bundle.js?ver='.iboost_get_mod_time("react/shortcode_slider/assets/bundle.js"); ?>" />    ></script>  
<link rel="stylesheet" href="<?php echo FLEX_IDX_URI . 'react/shortcode_slider/fonts/icons/style.css?ver='.iboost_get_mod_time("react/shortcode_slider/fonts/icons/style.css"); ?>" />      
<link rel="stylesheet" href="<?php echo FLEX_IDX_URI . 'react/shortcode_slider/assets/bundle.css?ver='.iboost_get_mod_time("react/shortcode_slider/assets/bundle.css"); ?>" />                  
<?php } ?>
