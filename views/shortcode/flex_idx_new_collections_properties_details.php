<?php

get_header();

global $wpdb;

$variableUrl = get_query_var('idxparamncollectionproperties');
$idxboost_search_settings = get_option('idxboost_search_settings');
$idxboost_agent_info = get_option('idxboost_agent_info');
$api_idx_access_token = flex_idx_get_access_token();

?>
<script>
	var __flex_g_settings = {
		propertyDetailPermalink: '<?php echo get_site_url(); ?>/property'
	}

	<?php
	$force_registration = isset($flex_idx_info["agent"]["force_registration"]) ? $flex_idx_info["agent"]["force_registration"] : 0;
	$force_registration_forced =  ($force_registration == "1") ?  $idxboost_agent_info['force_registration_forced'] : null;
	$signup_left_clicks = ($force_registration == "1" &&  isset($flex_idx_info["agent"]["signup_left_clicks"]) && !empty($flex_idx_info["agent"]["signup_left_clicks"]) ? (int)$flex_idx_info["agent"]["signup_left_clicks"] : 0);
	?>


	window.idx_main_settings = {
		force_registration: Boolean(<?php echo $force_registration; ?>),
		force_registration_forced: <?php echo  $force_registration == "1" ? json_encode($force_registration_forced) : "undefined"; ?>,
		signup_left_clicks: <?php echo  $force_registration == "1" ? $signup_left_clicks : "undefined"; ?>,
		search_settings: <?php echo json_encode($idxboost_search_settings); ?>,
		agent_info: <?php echo json_encode($idxboost_agent_info); ?>,
		access_token: "<?php echo $api_idx_access_token; ?>",
		board_info: <?php echo @json_encode($idxboost_search_settings['board_info']); ?>,
		paths: '<?php echo FLEX_IDX_URI . "react/collections_detail/"; ?>',
	}
	window.idxtoken = "<?php echo $access_token_service; ?>";

	window.idx_collections_settings = {
		client_type: "lead",
		collections_mode: "edit",
		param_url: '<?php echo $variableUrl; ?>',

		collections_path: "collections",
		detail_path: "collection"
	}
</script>

<div id="root-search"></div>


<?php wp_footer(); ?>