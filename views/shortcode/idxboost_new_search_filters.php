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
		active_ai : '<?php echo $ia_search; ?>',
		boost_conversion_active: (__flex_g_settings.force_registration_forced == "yes" ),
		restriction_mode: (__flex_g_settings.force_registration === "0" ? "soft":"forced"),
		clicks_registration: __flex_g_settings.signup_left_clicks,
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

  <div id="root" style="overflow-y: hidden"></div> 

