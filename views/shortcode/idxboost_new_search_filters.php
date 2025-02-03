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

<div id="root"></div>
<div id="tutorial-ai-modal"></div>
<div id="property-modal"></div>
<div id="gallery-modal"></div>
<div id="share-modal"></div>
<div id="contact-modal"></div>
<div id="save-modal"></div>
<div id="calculator-modal"></div> 

