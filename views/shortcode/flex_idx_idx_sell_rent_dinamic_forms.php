<?php

get_header();

$idxboost_search_settings = get_option('idxboost_search_settings');
$idxboost_search_filter_settings = get_option('idxboost_search_filter_settings');
$idxboost_agent_info = get_option('idxboost_agent_info');
$api_idx_access_token = flex_idx_get_access_token();
$ia_search = ( array_key_exists("ia_search", $flex_idx_info["agent"] ) && !empty($flex_idx_info["agent"]["ia_search"]) ) ? $flex_idx_info["agent"]["ia_search"] : '0';

$api_idx_access_token = flex_idx_get_access_token();

?>

	<?php 
		$force_registration = isset($flex_idx_info["agent"]["force_registration"]) ? $flex_idx_info["agent"]["force_registration"] : 0;
		$dash_to_dash_api_key = isset($flex_idx_info["agent"]["dash_to_dash_api_key"]) ? $flex_idx_info["agent"]["dash_to_dash_api_key"] : "";
		$dash_to_dash_app_id = isset($flex_idx_info["agent"]["dash_to_dash_app_id"]) ? $flex_idx_info["agent"]["dash_to_dash_app_id"] : "";
	 	$force_registration_forced =  ($force_registration == "1") ?  $idxboost_agent_info['force_registration_forced'] : null;
		$signup_left_clicks = ( $force_registration == "1" &&  isset($flex_idx_info["agent"]["signup_left_clicks"]) && !empty($flex_idx_info["agent"]["signup_left_clicks"]) ? (int)$flex_idx_info["agent"]["signup_left_clicks"] : 0); 
	
	//var_dump($force_registration_forced);
	?>

<script>
	const ibLeadToken = document.cookie.split('; ').find(row => row.startsWith('ib_lead_token'))?.split('=')[1];

	const first_name_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_firstname'))?.split('=')[1];
	const last_name_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_lastname'))?.split('=')[1];
	const email_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_email'))?.split('=')[1];
	const phone_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_phone'))?.split('=')[1];
	const new_phone_number_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_user_new_phone_number'))?.split('=')[1];
	const last_logged_in_username_lead = document.cookie.split('; ').find(row => row.startsWith('_ib_last_logged_in_username'))?.split('=')[1];


  const lead_detail = {
  	"name": first_name_lead,
  	"lastname" : last_name_lead,
  	"email" : email_lead,
  	"phone" : phone_lead,
  	"new_phone" : new_phone_number_lead,
  	"last_username" : last_logged_in_username_lead
  };

	window.idx_buy_sell_rent_forms = {
		form_type  : "<?php echo $atts["type"]; ?>",
		access_token: "<?php echo $api_idx_access_token; ?>",
		lead_token: ibLeadToken,
		lead : lead_detail,
		paths: '<?php echo FLEX_IDX_URI . "react/sell_rent_dinamic_forms/"; ?>'
	};

	window.idx_main_settings = {
		paths: '<?php echo FLEX_IDX_URI."react/sell_rent_dinamic_forms/"; ?>',
		active_ai : '<?php echo $ia_search; ?>',
		force_registration: Boolean(<?php echo $force_registration; ?>),
		force_registration_forced: <?php echo  $force_registration == "1" ? json_encode($force_registration_forced) : "undefined"; ?>,
		signup_left_clicks: <?php echo  $force_registration == "1" ? $signup_left_clicks : "undefined"; ?>,
		search_settings: <?php echo json_encode($idxboost_search_settings); ?>,
		agent_info:<?php echo json_encode($idxboost_agent_info); ?>,
		access_token:"<?php echo $api_idx_access_token; ?>",
		board_info : <?php echo @json_encode($idxboost_search_settings['board_info']); ?>
	}

</script>

<div id="root-dinamic-forms"></div>

<?php wp_footer(); ?>

