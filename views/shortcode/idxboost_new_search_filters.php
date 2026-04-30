<?php 
if (is_array($responseParms) && count($responseParms) > 0) {
	?>
	<script>
		var temp_mode = '<?php echo $atts["mode"]; ?>';
		var IB_IS_SEARCH_FILTER_PAGE = temp_mode != "slider" ? true : false;
		var IB_SEARCH_FILTER_PAGE = true;
		var IB_SEARCH_FILTER_PAGE_TITLE = '<?php the_title(); ?>';
		var initial_href = "";
	
		jQuery(function() {
			if (true === IB_SEARCH_FILTER_PAGE) {
				jQuery('#formRegister').append('<input type="hidden" name="source_registration_title" value="' + IB_SEARCH_FILTER_PAGE_TITLE + '">');
				jQuery('#formRegister').append('<input type="hidden" name="source_registration_url" value="' + location.href + '">');
				jQuery("#formRegister_ib_tags").val(IB_SEARCH_FILTER_PAGE_TITLE);
			}
		});
	</script>
	<?php
}

$idxboost_search_settings = get_option('idxboost_search_settings');
$idxboost_search_filter_settings = get_option('idxboost_search_filter_settings');
$idxboost_agent_info = get_option('idxboost_agent_info');
$api_idx_access_token = flex_idx_get_access_token();
$ia_search = (array_key_exists("ia_search", $flex_idx_info["agent"] ) && !empty($flex_idx_info["agent"]["ia_search"]) ) ? $flex_idx_info["agent"]["ia_search"] : '0';
$force_registration = isset($flex_idx_info["agent"]["force_registration"]) ? $flex_idx_info["agent"]["force_registration"] : 0;
$force_registration_forced =  ($force_registration == "1") ?  $idxboost_agent_info['force_registration_forced'] : null;
$signup_left_clicks = ($force_registration == "1" &&  isset($flex_idx_info["agent"]["signup_left_clicks"]) && !empty($flex_idx_info["agent"]["signup_left_clicks"]) ? (int)$flex_idx_info["agent"]["signup_left_clicks"] : 0); 
	?>
	<script>
		// var localURL = '<?php echo get_stylesheet_directory_uri(); ?>/shortcode/idx-search/';
		var __flex_g_settings = {
			propertyDetailPermalink: '<?php echo get_site_url(); ?>/property'
		};

		__flex_idx_search_filter_v2 = {
			searchFilterPermalink : '<?php echo get_permalink(); ?>',
		};

		window.idx_main_settings = {
			// search_filter_settings:<?php echo json_encode($idxboost_search_filter_settings); ?>,
			paths: '<?php echo FLEX_IDX_URI."react/new_search_filter/"; ?>',
			mode: '<?php echo $atts["mode"]; ?>',
			is_commercial: '<?php echo $atts["is_commercial"]; ?>',
			oh: '<?php echo $atts["oh"]; ?>',
			link: '<?php echo $atts["link"]; ?>',
			title: '<?php echo $atts["title"]; ?>',
			gallery: '<?php echo $atts["gallery"]; ?>',
			name_button: '<?php echo $atts["name_button"]; ?>',
			slider_item: '<?php echo $atts["slider_item"]; ?>',
			limit: '<?php echo $atts["limit"]; ?>',
			saveListings: '<?php echo FLEX_IDX_API_SEARCH_FILTER_SAVE; ?>',
			rk: '<?php echo get_option('flex_idx_alerts_keys'); ?>',
			wp_web_id: '<?php echo get_option('flex_idx_alerts_app_id'); ?>',
			active_ai: '<?php echo $ia_search; ?>',
			force_registration: Boolean(<?php echo $force_registration; ?>),
			force_registration_forced: <?php echo  $force_registration == "1" ? json_encode($force_registration_forced) : "undefined"; ?>,
			signup_left_clicks: <?php echo  $force_registration == "1" ? $signup_left_clicks : "undefined"; ?>,
			agent_info:<?php echo json_encode($idxboost_agent_info); ?>,
			access_token:"<?php echo $api_idx_access_token; ?>",
			board_info : <?php echo @json_encode($idxboost_search_settings['board_info']); ?>,

			search_settings: <?php
			if ( !empty($atts["filter_id"]) )
				echo json_encode(array_merge($flex_idx_info['search'], is_array($flex_idx_info['search_filter_settings']) ? $flex_idx_info['search_filter_settings'] : []));
			else
				echo json_encode($idxboost_search_settings); ?>,
			
			additional_tags: <?php echo json_encode(empty($atts['tags']) 
				? [] 
				: array_map('trim', explode(',', $atts['tags']))); ?>
		}	
		
		window.idxtoken = "<?php echo $access_token_service; ?>";
		<?php 
			if ( is_array($responseParms) && count($responseParms) > 0) {
				echo 'window.paramsMapSearch = '. json_encode($responseParms);
			}
		?>
	</script>  

	<!-- 
	<script type="module" crossorigin src="<?php echo get_stylesheet_directory_uri(); ?>/shortcode/idx-search/assets/index-BsLADlot.js"></script>
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/shortcode/idx-search/assets/index-Ys-jX6yu.css" />
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/shortcode/idx-search/fonts/icons/style.css" />
	<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU6VY2oHfII-RPAcZZu9qq843bpE3pLNo&libraries=drawing,marker,geometry"></script>
	-->
	<?php
if ($responseParms != NULL) {

	$resultado = processIdxSearch($responseParms);
	$apiResponse = $resultado['api_response'];

	if (isset($apiResponse['items']) && is_array($apiResponse['items'])) {
		$jsonData = [];

		if (isset($apiResponse['items']) && is_array($apiResponse['items'])) {
		    $jsonData = [];
		    $baseUrl = get_site_url();

		    foreach ($apiResponse['items'] as $item) {
		        $propertyType = ($item['class_id'] == 1) ? "Apartment" : "SingleFamilyResidence";
		        
		        $jsonData[] = [
		            "@context" => "https://schema.org",
		            "@type" => $propertyType,
		            "name" => !empty($item['address_short']) ? $item['address_short'] : $item['full_address'],
		            "accommodationCategory" => $item['style'] ?? "Condominium",
		            "floorSize" => [
		                "@type" => "QuantitativeValue",
		                "value" => $item['sqft'],
		                "unitCode" => "FTK"
		            ],
		            "address" => [
		                "@type" => "PostalAddress",
		                "streetAddress" => $item['full_address'],
		                "addressLocality" => isset($item['city']['name']) ? $item['city']['name'] : $item['address_large'],
		                "addressRegion" => "FL",
		                "postalCode" => $item['zip'],
		                "addressCountry" => "US"
		            ],
		            "geo" => [
		                "@type" => "GeoCoordinates",
		                "latitude" => $item['lat'],
		                "longitude" => $item['lng']
		            ],
		            "image" => $item['imagens'][0] ?? "",
		            "url" => $baseUrl  . '/' .  $item['slug']
		        ];
		    }

		    if (!empty($jsonData)) {
		        $jsonString = json_encode($jsonData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		        echo "\n<!-- Schema SEO Generate por IDX Boost -->\n";
		        echo '<script type="application/ld+json">' . $jsonString . '</script>' . "\n";
		    }
		} else {
		    echo "<!-- No se encontraron propiedades para generar Schema SEO -->";
		}

		if (!empty($jsonData)) {
			$jsonString = json_encode($jsonData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			echo "\n<!-- Schema SEO Generate por IDX Boost -->\n";
			echo '<script type="application/ld+json">' . $jsonString . '</script>' . "\n";
		}
	} else {
		echo "<!-- No se encontraron propiedades para generar Schema SEO -->";
	}
}
	?>

	<div id="root-search">
		<img 
			src="https://idxboost-spw-assets.idxboost.us/photos/white-square.jpg"
			width="600"
			height="600"
			alt="LCP Placeholder"
			style="display:block; max-width:100%; height:auto;"
			fetchpriority="high"
			decoding="async"
		/>
	</div>

	<script>

		function getCleanHref(search_url){
		  const url = new URL(window.location.href);

		  for (const param of TRACKING_PARAMS) {
		    console.log("param excluded:", param);
		    url.searchParams.delete(param);
		  }

		  return url.toString();
		}

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
			var search_filter_index_boards = window.idx_data_filter_alert.hasOwnProperty("index_boards") ? window.idx_data_filter_alert.index_boards : "";

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
						search_url: getCleanHref(search_url),
						search_count: search_count,
						search_condition: search_condition,
						index_boards: search_filter_index_boards,
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
