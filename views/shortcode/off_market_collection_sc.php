<?php
$idxboost_agent_info = get_option('idxboost_agent_info');
$idxboost_search_settings = get_option('idxboost_search_settings');
?>
	<script>
		var __flex_g_settings = {
			propertyDetailPermalink: '<?php echo get_site_url(); ?>/property'
		}

		<?php 
			$force_registration = isset($flex_idx_info["agent"]["force_registration"]) ? $flex_idx_info["agent"]["force_registration"] : 0;
			$dash_to_dash_api_key = isset($flex_idx_info["agent"]["dash_to_dash_api_key"]) ? $flex_idx_info["agent"]["dash_to_dash_api_key"] : "";
			$dash_to_dash_app_id = isset($flex_idx_info["agent"]["dash_to_dash_app_id"]) ? $flex_idx_info["agent"]["dash_to_dash_app_id"] : "";
		 	$force_registration_forced =  ($force_registration == "1") ?  $idxboost_agent_info['force_registration_forced'] : null;
			$signup_left_clicks = ( $force_registration == "1" &&  isset($flex_idx_info["agent"]["signup_left_clicks"]) && !empty($flex_idx_info["agent"]["signup_left_clicks"]) ? (int)$flex_idx_info["agent"]["signup_left_clicks"] : 0); 
		
		//var_dump($force_registration_forced);
		?>

		window.idx_main_settings = {
			paths: '<?php echo FLEX_IDX_URI."react/off-markets/"; ?>',
			active_ai : '<?php echo $ia_search; ?>',
			force_registration: Boolean(<?php echo $force_registration; ?>),
			force_registration_forced: <?php echo  $force_registration == "1" ? json_encode($force_registration_forced) : "undefined"; ?>,
			signup_left_clicks: <?php echo  $force_registration == "1" ? $signup_left_clicks : "undefined"; ?>,
			search_settings: <?php echo json_encode($idxboost_search_settings); ?>,
			agent_info:<?php echo json_encode($idxboost_agent_info); ?>,
			access_token:"<?php echo flex_idx_get_access_token(); ?>",
			board_info : <?php echo @json_encode($idxboost_search_settings['board_info']); ?>
		}
	</script>  

<div id="off_market_collection"></div>
